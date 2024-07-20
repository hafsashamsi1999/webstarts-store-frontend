<?php

namespace App\Utility\Sites\Embed;

use App\Models\ChatApi;
use App\Models\Sites;
use App\Utility\Sites\Dynamic\DynamicHead;

class ChatEmbedder
{
    public static $api_host = 'https://chat.secure.website/api';
    private $api_secret = 'cnu8jcn13902938hf';
    private $token = null;

    public $site;
    protected $chatmodel;
    
    function __construct(Sites $site)
    {
        $this->site = $site;
        $this->chatmodel = $this->findOrCreate();
    }

    public function findOrCreate()
    {
        $model = ChatApi::where("site_id", $this->site->id)->first();

        if (is_null($model)) {
            $model = $this->setup();
        }
        return $model;
    }

    public function embed()
    {
        $this->generateSiteHead();

        return [
            'message' => 'Chat embed setup successfully.',
        ];
    }

    public function remove()
    {
        $dh = new DynamicHead($this->site->storage());
        $dh->remove_json_entity('chat', TRUE);

        return [
            'message' => 'Chat embed removed successfully.',
        ];
    }

    public function generateSiteHead()
    {
        $head = new DynamicHead($this->site->storage());
        $head->save_json_entities($this->getSiteDependencies());

        return $this;
    }

    public function getSiteDependencies()
    {
        return [
            [
                "id" => "chat",
                "node" => "dataonly",
                "value" => [
                    "entityId" => $this->chatmodel->chat_entity_id,
                ]
            ]
        ];
    }

    /**
     * [setup description]
     * @return Reliese\Database\Eloquent\Model
     */
    public function setup()
    {
        if(is_null($this->site)) {
            throw new \Exception("There was an issue generating your Chat App, please try again.");
        }

        $response = $this->request('POST', 'entities', [
            'api_key' => $this->api_secret,
            'external_app_id' => $this->site->id,
            'external_app' => 'webstarts'
        ]);

        if(empty($response) || empty($response->id)) {
            throw new \Exception("An error occurred while setting up chat. Could not connect to chat server.", 1);
        }

        $chatAPI = ChatApi::create([
            'chat_entity_id' => $response->id,
            'site_id' => $this->site->id
        ]);

        return $chatAPI;
    }

    /**
     * [request description]
     * @param  string $http_verb   [description]
     * @param  string $endpoint    [description]
     * @param  string $params      [description]
     * @param  array  $authHeaders [description]
     * @return StdClass object     [description]
     */
    protected function request($http_verb='POST', $endpoint, $params='', $authHeaders = [])
    {
        $client = new \GuzzleHttp\Client();
        
        $response = $client->request($http_verb, self::$api_host.'/'.$endpoint, [
            'form_params' => $params,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            //'auth' => [$creds['username'], $creds['password']],
            'debug' => false,
            //'verify' => 'certificates/certificate.pem'
        ]);

        if($response->getStatusCode() == '200') {

            $responseBody = $response->getBody();

            try {
                if(empty($responseBody) || $responseBody === false) {
                    $return = json_decode(json_encode(['error' => 'An unexpected error occurred while requesting chat information']));
                } else {
                    $return = json_decode($responseBody);
                }
            } catch(\Exception $e) {
                $return = json_decode(json_encode(['error' => 'An unexpected error occurred while requesting chat information']));
            }

            return $return;
        }

        return json_decode(json_encode(['error' => 'An unexpected error occurred while requesting chat information']));
    }
}
