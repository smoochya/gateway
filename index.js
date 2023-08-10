//import { sprintf, __ } from '@wordpress/i18n';
//import { registerPaymentMethod } from '@woocommerce/blocks-registry';
//import { decodeEntities } from '@wordpress/html-entities';
//import { getSetting } from '@woocommerce/settings';
const compose = window.wp.compose;
const useRef = window.wp.element.useRef;


//const settings = getSetting( 'dummy_data', {} );
//
//const defaultLabel = __(
//	'Dummy Payments',
//	'woo-gutenberg-products-block'
//);
//
//const label = decodeEntities( settings.title ) || defaultLabel;
///**
// * Content component
// */
const Content = (props) => {
	
	return React.createElement('p', props, "Dummy");
	
};
///**
// * Label component
// *
// * @param {*} props Props from payment API.
// */
//const Label = ( props ) => {
//	const { PaymentMethodLabel } = props.components;
//	return <PaymentMethodLabel text={ label } />;
//};

/**
 * Dummy payment method config object.
 * 
 * 
 */

class Hello extends React.Component {

	
	constructor(props) {
		super(props);
		this.props.updateOption = function  updateOption (){
			const { emitResponse } = this.props.emitResponse;
			const { onPaymentMethodProcessing } = this.props.eventRegistration;
			React.useEffect(function () {
				const unsubscribe = onPaymentProcessing( async () => {
					// Here we can do any processing we need, and then emit a response.
					// For example, we might validate a custom field, or perform an AJAX request, and then emit a response indicating it is valid or not.
					const myGatewayCustomData = '12345';
					const customDataIsValid = !! myGatewayCustomData.length;
		
					if ( customDataIsValid ) {
						return {
							type: emitResponse.responseTypes.SUCCESS,
							meta: {
								paymentMethodData: {
									myGatewayCustomData,
								},
							},
						};
					}
		
					return {
						type: emitResponse.responseTypes.ERROR,
						message: 'There was an error',
					};
				} );
				// Unsubscribes when this component is unmounted.
				return () => {
					unsubscribe();
				};
	

			  },[onPaymentMethodProcessing] );
		  
		};
	}
	
	render() {
		
	  return React.createElement('div', null , [`Hello ${this.props.toWhat}`, this.props.updateOption] );
	}
}

var _m = React.createElement(Hello, {toWhat: 'World'}, null)
  



const Dummy = {
	name: "dummy",
	label: window.wp.element.createElement('div'),
	content: _m,
	edit: window.wp.element.createElement('div'),
	canMakePayment: () => true,
	ariaLabel: 'dummy',
	supports: {
		features: ['products'],
	},
};

//const bl = window.wp.blocks.createBlock();

window.wc.wcBlocksRegistry.registerPaymentMethod( Dummy );
_m.props.toWhat = 'Universe'
console.log(_m)

var val = "This is a value sent from the checkout ";
const extensionCartUpdate = window.wc.blocksCheckout.extensionCartUpdate;
console.log(wc.wcBlocksRegistry.getPaymentMethods())
extensionCartUpdate( {
	namespace: 'extension-unique-namespace',
	data: {
		val,
	},
} );


