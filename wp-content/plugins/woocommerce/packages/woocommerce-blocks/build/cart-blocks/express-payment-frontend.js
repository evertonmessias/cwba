(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[14],{104:function(e,t,n){"use strict";var s=n(0);t.a=function(e){let{icon:t,size:n=24,...c}=e;return Object(s.cloneElement)(t,{width:n,height:n,...c})}},237:function(e,t){},248:function(e,t){},250:function(e,t,n){"use strict";n.d(t,"b",(function(){return r})),n.d(t,"a",(function(){return a}));var s=n(28),c=n(185);const o=function(){let e=arguments.length>0&&void 0!==arguments[0]&&arguments[0];const{paymentMethods:t,expressPaymentMethods:n,paymentMethodsInitialized:o,expressPaymentMethodsInitialized:r}=Object(c.b)(),a=Object(s.a)(t),i=Object(s.a)(n);return{paymentMethods:e?i:a,isInitialized:e?r:o}},r=()=>o(!1),a=()=>o(!0)},252:function(e,t,n){"use strict";var s=n(10),c=n.n(s),o=n(0),r=n(4),a=n.n(r);const i=e=>"wc-block-components-payment-method-icon wc-block-components-payment-method-icon--"+e;var l=e=>{let{id:t,src:n=null,alt:s=""}=e;return n?Object(o.createElement)("img",{className:i(t),src:n,alt:s}):null},p=n(47);const u=[{id:"alipay",alt:"Alipay",src:p.l+"payment-methods/alipay.svg"},{id:"amex",alt:"American Express",src:p.l+"payment-methods/amex.svg"},{id:"bancontact",alt:"Bancontact",src:p.l+"payment-methods/bancontact.svg"},{id:"diners",alt:"Diners Club",src:p.l+"payment-methods/diners.svg"},{id:"discover",alt:"Discover",src:p.l+"payment-methods/discover.svg"},{id:"eps",alt:"EPS",src:p.l+"payment-methods/eps.svg"},{id:"giropay",alt:"Giropay",src:p.l+"payment-methods/giropay.svg"},{id:"ideal",alt:"iDeal",src:p.l+"payment-methods/ideal.svg"},{id:"jcb",alt:"JCB",src:p.l+"payment-methods/jcb.svg"},{id:"laser",alt:"Laser",src:p.l+"payment-methods/laser.svg"},{id:"maestro",alt:"Maestro",src:p.l+"payment-methods/maestro.svg"},{id:"mastercard",alt:"Mastercard",src:p.l+"payment-methods/mastercard.svg"},{id:"multibanco",alt:"Multibanco",src:p.l+"payment-methods/multibanco.svg"},{id:"p24",alt:"Przelewy24",src:p.l+"payment-methods/p24.svg"},{id:"sepa",alt:"Sepa",src:p.l+"payment-methods/sepa.svg"},{id:"sofort",alt:"Sofort",src:p.l+"payment-methods/sofort.svg"},{id:"unionpay",alt:"Union Pay",src:p.l+"payment-methods/unionpay.svg"},{id:"visa",alt:"Visa",src:p.l+"payment-methods/visa.svg"},{id:"wechat",alt:"WeChat",src:p.l+"payment-methods/wechat.svg"}];var d=n(61);n(248),t.a=e=>{let{icons:t=[],align:n="center",className:s}=e;const r=(e=>{const t={};return e.forEach(e=>{let n={};"string"==typeof e&&(n={id:e,alt:e,src:null}),"object"==typeof e&&(n={id:e.id||"",alt:e.alt||"",src:e.src||null}),n.id&&Object(d.a)(n.id)&&!t[n.id]&&(t[n.id]=n)}),Object.values(t)})(t);if(0===r.length)return null;const i=a()("wc-block-components-payment-method-icons",{"wc-block-components-payment-method-icons--align-left":"left"===n,"wc-block-components-payment-method-icons--align-right":"right"===n},s);return Object(o.createElement)("div",{className:i},r.map(e=>{const t={...e,...(n=e.id,u.find(e=>e.id===n)||{})};var n;return Object(o.createElement)(l,c()({key:"payment-method-icon-"+e.id},t))}))}},258:function(e,t,n){"use strict";n.d(t,"a",(function(){return o}));var s=n(0),c=(n(8),n(177));n(237);const o=e=>{let{errorMessage:t="",propertyName:n="",elementId:o=""}=e;const{getValidationError:r,getValidationErrorId:a}=Object(c.b)();if(!t||"string"!=typeof t){const e=r(n)||{};if(!e.message||e.hidden)return null;t=e.message}return Object(s.createElement)("div",{className:"wc-block-components-validation-error",role:"alert"},Object(s.createElement)("p",{id:a(o)},t))}},261:function(e,t,n){"use strict";n.d(t,"a",(function(){return d}));var s=n(1),c=n(9),o=n(5),r=n(19),a=n(29),i=n(0),l=n(226),p=n(177),u=n(39);const d=()=>{const{cartCoupons:e,cartIsLoading:t}=Object(a.a)(),{addErrorNotice:n}=Object(u.a)(),{addSnackbarNotice:d}=(()=>{const{notices:e,createSnackbarNotice:t,removeSnackbarNotice:n,setIsSuppressed:s}=Object(l.b)(),c=Object(i.useRef)(e);Object(i.useEffect)(()=>{c.current=e},[e]);const o=Object(i.useMemo)(()=>({removeNotices:function(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;c.current.forEach(t=>{null!==e&&t.status!==e||n(t.id)})},removeSnackbarNotice:n}),[n]),r=Object(i.useMemo)(()=>({addSnackbarNotice:function(e){let n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};t(e,n)}}),[t]);return{notices:e,...o,...r,setIsSuppressed:s}})(),{setValidationErrors:m}=Object(p.b)();return{appliedCoupons:e,isLoading:t,...Object(c.useSelect)((e,t)=>{let{dispatch:c}=t;const a=e(o.CART_STORE_KEY),i=a.isApplyingCoupon(),l=a.isRemovingCoupon(),{applyCoupon:p,removeCoupon:u,receiveApplyingCoupon:b}=c(o.CART_STORE_KEY);return{applyCoupon:e=>{p(e).then(t=>{!0===t&&d(Object(s.sprintf)(
/* translators: %s coupon code. */
Object(s.__)('Coupon code "%s" has been applied to your cart.','woocommerce'),e),{id:"coupon-form"})}).catch(e=>{m({coupon:{message:Object(r.decodeEntities)(e.message),hidden:!1}}),b("")})},removeCoupon:e=>{u(e).then(t=>{!0===t&&d(Object(s.sprintf)(
/* translators: %s coupon code. */
Object(s.__)('Coupon code "%s" has been removed from your cart.','woocommerce'),e),{id:"coupon-form"})}).catch(e=>{n(e.message,{id:"coupon-form"}),b("")})},isApplyingCoupon:i,isRemovingCoupon:l}},[n,d])}}},275:function(e,t){},276:function(e,t,n){"use strict";var s=n(17),c=n.n(s),o=n(0),r=n(1),a=n(3),i=(n(8),n(2)),l=n(96);class p extends a.Component{constructor(){super(...arguments),c()(this,"state",{errorMessage:"",hasError:!1})}static getDerivedStateFromError(e){return{errorMessage:e.message,hasError:!0}}render(){const{hasError:e,errorMessage:t}=this.state,{isEditor:n}=this.props;if(e){let e=Object(r.__)("This site is experiencing difficulties with this payment method. Please contact the owner of the site for assistance.",'woocommerce');(n||i.CURRENT_USER_IS_ADMIN)&&(e=t||Object(r.__)("There was an error with this payment method. Please verify it's configured correctly.",'woocommerce'));const s=[{id:"0",content:e,isDismissible:!1,status:"error"}];return Object(o.createElement)(l.StoreNoticesContainer,{notices:s})}return this.props.children}}p.defaultProps={isEditor:!1},t.a=p},299:function(e,t){},300:function(e,t,n){"use strict";var s=n(0),c=n(1),o=n(323),r=n(250),a=n(18),i=n(185),l=n(30),p=n.n(l),u=n(276);t.a=()=>{const{isEditor:e}=Object(a.a)(),{setActivePaymentMethod:t,setExpressPaymentError:n,activePaymentMethod:l,paymentMethodData:d,setPaymentStatus:m}=Object(i.b)(),b=Object(o.a)(),{paymentMethods:h}=Object(r.a)(),g=Object(s.useRef)(l),v=Object(s.useRef)(d),j=Object(s.useCallback)(e=>()=>{g.current=l,v.current=d,m().started(),t(e)},[l,d,t,m]),y=Object(s.useCallback)(()=>{m().pristine(),t(g.current,v.current)},[t,m]),O=Object(s.useCallback)(e=>{m().error(e),n(e),t(g.current,v.current)},[t,m,n]),E=Object(s.useCallback)((function(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";p()("Express Payment Methods should use the provided onError handler instead.",{alternative:"onError",plugin:"woocommerce-gutenberg-products-block",link:"https://github.com/woocommerce/woocommerce-gutenberg-products-block/pull/4228"}),e?O(e):n("")}),[n,O]),f=Object.entries(h),k=f.length>0?f.map(t=>{let[n,c]=t;const o=e?c.edit:c.content;return Object(s.isValidElement)(o)?Object(s.createElement)("li",{key:n,id:"express-payment-method-"+n},Object(s.cloneElement)(o,{...b,onClick:j(n),onClose:y,onError:O,setExpressPaymentError:E})):null}):Object(s.createElement)("li",{key:"noneRegistered"},Object(c.__)("No registered Payment Methods",'woocommerce'));return Object(s.createElement)(u.a,{isEditor:e},Object(s.createElement)("ul",{className:"wc-block-components-express-payment__event-buttons"},k))}},318:function(e,t,n){"use strict";var s=n(0),c=n(14);const o=Object(s.createElement)(c.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},Object(s.createElement)(c.Path,{fillRule:"evenodd",d:"M5.5 9.5v-2h13v2h-13zm0 3v4h13v-4h-13zM4 7a1 1 0 011-1h14a1 1 0 011 1v10a1 1 0 01-1 1H5a1 1 0 01-1-1V7z",clipRule:"evenodd"}));t.a=o},323:function(e,t,n){"use strict";n.d(t,"a",(function(){return z}));var s=n(1),c=n(38),o=n(0),r=n(4),a=n.n(r),i=n(14),l=Object(o.createElement)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},Object(o.createElement)("g",{fill:"none",fillRule:"evenodd"},Object(o.createElement)("path",{d:"M0 0h24v24H0z"}),Object(o.createElement)("path",{fill:"#000",fillRule:"nonzero",d:"M17.3 8v1c1 .2 1.4.9 1.4 1.7h-1c0-.6-.3-1-1-1-.8 0-1.3.4-1.3.9 0 .4.3.6 1.4 1 1 .2 2 .6 2 1.9 0 .9-.6 1.4-1.5 1.5v1H16v-1c-.9-.1-1.6-.7-1.7-1.7h1c0 .6.4 1 1.3 1 1 0 1.2-.5 1.2-.8 0-.4-.2-.8-1.3-1.1-1.3-.3-2.1-.8-2.1-1.8 0-.9.7-1.5 1.6-1.6V8h1.3zM12 10v1H6v-1h6zm2-2v1H6V8h8zM2 4v16h20V4H2zm2 14V6h16v12H4z"}),Object(o.createElement)("path",{stroke:"#000",strokeLinecap:"round",d:"M6 16c2.6 0 3.9-3 1.7-3-2 0-1 3 1.5 3 1 0 1-.8 2.8-.8"}))),p=Object(o.createElement)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},Object(o.createElement)(i.Path,{fillRule:"evenodd",d:"M18.646 9H20V8l-1-.5L12 4 5 7.5 4 8v1h14.646zm-3-1.5L12 5.677 8.354 7.5h7.292zm-7.897 9.44v-6.5h-1.5v6.5h1.5zm5-6.5v6.5h-1.5v-6.5h1.5zm5 0v6.5h-1.5v-6.5h1.5zm2.252 8.81c0 .414-.334.75-.748.75H4.752a.75.75 0 010-1.5h14.5a.75.75 0 01.749.75z",clipRule:"evenodd"})),u=Object(o.createElement)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},Object(o.createElement)(i.Path,{d:"M3.25 12a8.75 8.75 0 1117.5 0 8.75 8.75 0 01-17.5 0zM12 4.75a7.25 7.25 0 100 14.5 7.25 7.25 0 000-14.5zm-1.338 4.877c-.314.22-.412.452-.412.623 0 .171.098.403.412.623.312.218.783.377 1.338.377.825 0 1.605.233 2.198.648.59.414 1.052 1.057 1.052 1.852 0 .795-.461 1.438-1.052 1.852-.41.286-.907.486-1.448.582v.316a.75.75 0 01-1.5 0v-.316a3.64 3.64 0 01-1.448-.582c-.59-.414-1.052-1.057-1.052-1.852a.75.75 0 011.5 0c0 .171.098.403.412.623.312.218.783.377 1.338.377s1.026-.159 1.338-.377c.314-.22.412-.452.412-.623 0-.171-.098-.403-.412-.623-.312-.218-.783-.377-1.338-.377-.825 0-1.605-.233-2.198-.648-.59-.414-1.052-1.057-1.052-1.852 0-.795.461-1.438 1.052-1.852a3.64 3.64 0 011.448-.582V7.5a.75.75 0 011.5 0v.316c.54.096 1.039.296 1.448.582.59.414 1.052 1.057 1.052 1.852a.75.75 0 01-1.5 0c0-.171-.098-.403-.412-.623-.312-.218-.783-.377-1.338-.377s-1.026.159-1.338.377z"})),d=n(318),m=n(104),b=n(61),h=n(63);n(275);const g={bank:p,bill:u,card:d.a,checkPayment:l};var v=e=>{let{icon:t="",text:n=""}=e;const s=!!t,c=Object(o.useCallback)(e=>s&&Object(b.a)(e)&&Object(h.b)(g,e),[s]),r=a()("wc-block-components-payment-method-label",{"wc-block-components-payment-method-label--with-icon":s});return Object(o.createElement)("span",{className:r},c(t)?Object(o.createElement)(m.a,{icon:g[t]}):t,n)},j=n(252),y=n(2),O=n(30),E=n.n(O),f=n(137),k=n(258),w=n(29),S=n(261),P=n(27),C=n(35),_=n(185),x=n(68),R=n(49);const M=(e,t)=>{const n=[],c=(t,n)=>{const s=n+"_tax",c=Object(h.b)(e,n)&&Object(b.a)(e[n])?parseInt(e[n],10):0;return{key:n,label:t,value:c,valueWithTax:c+(Object(h.b)(e,s)&&Object(b.a)(e[s])?parseInt(e[s],10):0)}};return n.push(c(Object(s.__)("Subtotal:",'woocommerce'),"total_items")),n.push(c(Object(s.__)("Fees:",'woocommerce'),"total_fees")),n.push(c(Object(s.__)("Discount:",'woocommerce'),"total_discount")),n.push({key:"total_tax",label:Object(s.__)("Taxes:",'woocommerce'),value:parseInt(e.total_tax,10),valueWithTax:parseInt(e.total_tax,10)}),t&&n.push(c(Object(s.__)("Shipping:",'woocommerce'),"total_shipping")),n};var I=n(66);const z=()=>{const{isCalculating:e,isComplete:t,isIdle:n,isProcessing:r,onCheckoutBeforeProcessing:a,onCheckoutValidationBeforeProcessing:i,onCheckoutAfterProcessingWithSuccess:l,onCheckoutAfterProcessingWithError:p,onSubmit:u,customerId:d}=Object(C.b)(),{currentStatus:m,activePaymentMethod:b,onPaymentProcessing:h,setExpressPaymentError:g,shouldSavePayment:O}=Object(_.b)(),{shippingErrorStatus:z,shippingErrorTypes:N,onShippingRateSuccess:T,onShippingRateFail:A,onShippingRateSelectSuccess:V,onShippingRateSelectFail:B}=Object(x.b)(),{shippingRates:D,isLoadingRates:L,selectedRates:F,isSelectingRate:H,selectShippingRate:W,needsShipping:G}=Object(I.a)(),{billingData:J,shippingAddress:U,setShippingAddress:Y}=Object(R.b)(),{cartItems:K,cartFees:X,cartTotals:q,extensions:Q}=Object(w.a)(),{appliedCoupons:Z}=Object(S.a)(),{noticeContexts:$,responseTypes:ee}=Object(P.c)(),te=Object(o.useRef)(M(q,G)),ne=Object(o.useRef)({label:Object(s.__)("Total",'woocommerce'),value:parseInt(q.total_price,10)});Object(o.useEffect)(()=>{te.current=M(q,G),ne.current={label:Object(s.__)("Total",'woocommerce'),value:parseInt(q.total_price,10)}},[q,G]);const se=Object(o.useCallback)((function(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";E()("setExpressPaymentError should only be used by Express Payment Methods (using the provided onError handler).",{alternative:"",plugin:"woocommerce-gutenberg-products-block",link:"https://github.com/woocommerce/woocommerce-gutenberg-products-block/pull/4228"}),g(e)}),[g]);return{activePaymentMethod:b,billing:{appliedCoupons:Z,billingData:J,cartTotal:ne.current,cartTotalItems:te.current,currency:Object(c.getCurrencyFromPriceResponse)(q),customerId:d,displayPricesIncludingTax:Object(y.getSetting)("displayCartPricesIncludingTax",!1)},cartData:{cartItems:K,cartFees:X,extensions:Q},checkoutStatus:{isCalculating:e,isComplete:t,isIdle:n,isProcessing:r},components:{LoadingMask:f.a,PaymentMethodIcons:j.a,PaymentMethodLabel:v,ValidationInputError:k.a},emitResponse:{noticeContexts:$,responseTypes:ee},eventRegistration:{onCheckoutAfterProcessingWithError:p,onCheckoutAfterProcessingWithSuccess:l,onCheckoutBeforeProcessing:a,onCheckoutValidationBeforeProcessing:i,onPaymentProcessing:h,onShippingRateFail:A,onShippingRateSelectFail:B,onShippingRateSelectSuccess:V,onShippingRateSuccess:T},onSubmit:u,paymentStatus:m,setExpressPaymentError:se,shippingData:{isSelectingRate:H,needsShipping:G,selectedRates:F,setSelectedRates:W,setShippingAddress:Y,shippingAddress:U,shippingRates:D,shippingRatesLoading:L},shippingStatus:{shippingErrorStatus:z,shippingErrorTypes:N},shouldSavePayment:O}}},419:function(e,t,n){"use strict";n.r(t);var s=n(0),c=n(29),o=n(4),r=n.n(o),a=n(1),i=n(250),l=n(27),p=n(35),u=n(185),d=n(79),m=n(137),b=n(300);n(299);var h=()=>{const{paymentMethods:e,isInitialized:t}=Object(i.a)(),{noticeContexts:n}=Object(l.c)(),{isCalculating:c,isProcessing:o,isAfterProcessing:r,isBeforeProcessing:h,isComplete:g,hasError:v}=Object(p.b)(),{currentStatus:j}=Object(u.b)();if(!t||t&&0===Object.keys(e).length)return null;const y=o||r||h||g&&!v;return Object(s.createElement)(s.Fragment,null,Object(s.createElement)(m.a,{isLoading:c||y||j.isDoingExpressPayment},Object(s.createElement)("div",{className:"wc-block-components-express-payment wc-block-components-express-payment--cart"},Object(s.createElement)("div",{className:"wc-block-components-express-payment__content"},Object(s.createElement)(d.a,{context:n.EXPRESS_PAYMENTS},Object(s.createElement)(b.a,null))))),Object(s.createElement)("div",{className:"wc-block-components-express-payment-continue-rule wc-block-components-express-payment-continue-rule--cart"},Object(a.__)("Or",'woocommerce')))};t.default=e=>{let{className:t}=e;const{cartNeedsPayment:n}=Object(c.a)();return n?Object(s.createElement)("div",{className:r()("wc-block-cart__payment-options",t)},Object(s.createElement)(h,null)):null}},96:function(e,t,n){}}]);