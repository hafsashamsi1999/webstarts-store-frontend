import SelectPlan from './components/SelectPlan';
import SelectBilling from './components/SelectBilling';
import IndexOffer from './components/IndexOffer';

export default{
	mode: 'history',

	routes: [
	{
		path: '/select-plan',
		component: SelectPlan
	},

	{
		path: '/select-billing',
		component: SelectBilling
	},

	{
		path: '/index-offer',
		component: IndexOffer
	},
	]
}