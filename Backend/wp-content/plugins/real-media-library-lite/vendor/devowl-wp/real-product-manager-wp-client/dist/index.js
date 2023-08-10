var devowlWp_realProductManagerWpClient;!function(){"use strict";var e,t={3627:function(e,t,n){n.r(t),n.d(t,{CLICK_HANDLER_PLUGIN_UPDATE_MODAL_ATTRIBUTE:function(){return ze},FeedbackModal:function(){return De},HASH_HANDLER_PLUGIN_UPDATE_MODAL_PREFIX:function(){return Me},LearnMoreTag:function(){return Ge},OptionStore:function(){return y},PLUGIN_UPDATE_FORM_LAYOUT:function(){return Je},PLUGIN_UPDATE_FORM_LAYOUT_MARGIN_BOTTOM:function(){return Ye},PluginUpdateEmbed:function(){return lt},PluginUpdateForm:function(){return $e},PluginUpdateLicenseList:function(){return at},PluginUpdateModal:function(){return it},PluginUpdateStore:function(){return he},PluginUpdateTermFields:function(){return Be},Provider:function(){return ve},RootStore:function(){return fe},listenHashPluginUpdate:function(){return Xe},listenPluginDeactivation:function(){return Ce},listenPluginUpdateLinkClick:function(){return Le},locationRestAnnouncementActive:function(){return Z},locationRestLicenseDelete:function(){return ue},locationRestLicenseRetry:function(){return ce},locationRestPluginFeedbackPost:function(){return _e},locationRestPluginUpdateGet:function(){return me},locationRestPluginUpdatePatch:function(){return k},locationRestPluginUpdateSkipPost:function(){return P},useStores:function(){return be}});var r,a,i,l=n(1533),o=n(3371),s=n(5481),c=n(4741),u=n(6762),p=n(3340),d=n(7821),m=devowlWp_utils,h=n(6724),f=n(5558),g=n(3841),b=n(5952),v=n(9303),y=(r=function(e){(0,g.Z)(n,e);var t=(0,b.Z)(n);function n(e){var r;return(0,u.Z)(this,n),r=t.call(this),(0,h.Z)(r,"others",a,(0,f.Z)(r)),r.pureSlug=void 0,r.pureSlugCamelCased=void 0,r.rootStore=void 0,r.rootStore=e,r.pureSlug=m.BaseOptions.getPureSlug({NODE_ENV:"production",env:"production",rootSlug:"devowl-wp",slug:"real-product-manager-wp-client",ANTD_PREFIX:"rpm-wpc-antd"}),r.pureSlugCamelCased=m.BaseOptions.getPureSlug({NODE_ENV:"production",env:"production",rootSlug:"devowl-wp",slug:"real-product-manager-wp-client",ANTD_PREFIX:"rpm-wpc-antd"},!0),(0,d.runInAction)((function(){return Object.assign((0,f.Z)(r),window[r.pureSlugCamelCased])})),r}return n}(m.BaseOptions),a=(0,v.Z)(r.prototype,"others",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),r),w=n(5450),E=n.n(w),R=n(4115),Z={path:"/announcement/:slug/active",method:m.RouteHttpVerb.POST},k={path:"/plugin-update/:slug",method:m.RouteHttpVerb.PATCH},P={path:"/plugin-update/:slug/skip",method:m.RouteHttpVerb.POST};function U(){return i||(i=(0,m.createRequestFactory)(window[m.BaseOptions.getPureSlug({NODE_ENV:"production",env:"production",rootSlug:"devowl-wp",slug:"real-product-manager-wp-client",ANTD_PREFIX:"rpm-wpc-antd"},!0)]))}var S,O,N,I,x,T,_,A,F,D,C,z,L,M,X,K,q,W,V,B,j,H,G,J,Y,$,Q,ee,te,ne,re,ae,ie,le,oe,se=function(){var e;return(e=U()).request.apply(e,arguments)},ce={path:"/plugin-update/:slug/license/:blogId/retry",method:m.RouteHttpVerb.POST},ue={path:"/plugin-update/:slug/license/:blogId",method:m.RouteHttpVerb.DELETE},pe=(S=function e(t,n){var r=this;(0,u.Z)(this,e),(0,h.Z)(this,"busy",O,this),(0,h.Z)(this,"blog",N,this),(0,h.Z)(this,"host",I,this),(0,h.Z)(this,"programmatically",x,this),(0,h.Z)(this,"blogName",T,this),(0,h.Z)(this,"installationType",_,this),(0,h.Z)(this,"code",A,this),(0,h.Z)(this,"hint",F,this),(0,h.Z)(this,"remote",D,this),(0,h.Z)(this,"noUsage",C,this),this.store=void 0,this.retry=(0,d.flow)(E().mark((function e(){var t;return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return this.busy=!0,e.prev=1,e.next=4,se({location:ce,params:{slug:this.store.slug,blogId:this.blog}});case 4:t=e.sent,(0,d.set)(this,t),e.next=12;break;case 8:throw e.prev=8,e.t0=e.catch(1),console.log(e.t0),e.t0;case 12:return e.prev=12,this.busy=!1,e.finish(12);case 15:case"end":return e.stop()}}),e,this,[[1,8,12,15]])}))),this.deactivate=(0,d.flow)(E().mark((function e(){var t;return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return this.busy=!0,e.prev=1,e.next=4,se({location:ue,params:{slug:this.store.slug,blogId:this.blog}});case 4:t=e.sent,(0,d.set)(this,t),e.next=12;break;case 8:throw e.prev=8,e.t0=e.catch(1),console.log(e.t0),e.t0;case 12:return e.prev=12,this.busy=!1,e.finish(12);case 15:case"end":return e.stop()}}),e,this,[[1,8,12,15]])}))),(0,d.runInAction)((function(){return(0,d.set)(r,t)})),this.store=n},O=(0,v.Z)(S.prototype,"busy",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:function(){return!1}}),N=(0,v.Z)(S.prototype,"blog",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),I=(0,v.Z)(S.prototype,"host",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),x=(0,v.Z)(S.prototype,"programmatically",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),T=(0,v.Z)(S.prototype,"blogName",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),_=(0,v.Z)(S.prototype,"installationType",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),A=(0,v.Z)(S.prototype,"code",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),F=(0,v.Z)(S.prototype,"hint",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),D=(0,v.Z)(S.prototype,"remote",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),C=(0,v.Z)(S.prototype,"noUsage",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),S),de=(z=function(){function e(t,n){(0,u.Z)(this,e),(0,h.Z)(this,"busy",L,this),(0,h.Z)(this,"slug",M,this),(0,h.Z)(this,"licenses",X,this),(0,h.Z)(this,"hasInteractedWithFormOnce",K,this),(0,h.Z)(this,"name",q,this),(0,h.Z)(this,"needsLicenseKeys",W,this),(0,h.Z)(this,"announcementsActive",V,this),(0,h.Z)(this,"allowsAutoUpdates",B,this),(0,h.Z)(this,"allowsTelemetry",j,this),(0,h.Z)(this,"allowsNewsletter",H,this),(0,h.Z)(this,"potentialNewsletterUser",G,this),(0,h.Z)(this,"privacyProvider",J,this),(0,h.Z)(this,"privacyPolicy",Y,this),(0,h.Z)(this,"accountSiteUrl",$,this),(0,h.Z)(this,"licenseKeyHelpUrl",Q,this),(0,h.Z)(this,"checkUpdateLink",ee,this),(0,h.Z)(this,"invalidKeysError",te,this),(0,h.Z)(this,"showBlogName",ne,this),(0,h.Z)(this,"showNetworkWideUpdateIssueNotice",re,this),this.store=void 0,this.setAnnouncementActive=(0,d.flow)(E().mark((function e(t){var n;return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return this.busy=!0,e.prev=1,e.next=4,se({location:Z,params:{slug:this.slug},request:{state:t}});case 4:return(n=e.sent).success&&(this.announcementsActive=t),e.abrupt("return",n.success);case 9:throw e.prev=9,e.t0=e.catch(1),console.log(e.t0),e.t0;case 13:return e.prev=13,this.busy=!1,e.finish(13);case 16:case"end":return e.stop()}}),e,this,[[1,9,13,16]])}))),this.update=(0,d.flow)(E().mark((function e(t){var n,r,a;return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return this.busy=!0,this.invalidKeysError=void 0,e.prev=2,e.next=5,se({location:k,params:{slug:this.slug},request:t});case 5:n=e.sent,this.fromResponse(n),e.next=14;break;case 9:throw e.prev=9,e.t0=e.catch(2),console.log(e.t0),null!==(r=e.t0.responseJSON)&&void 0!==r&&null!==(a=r.data)&&void 0!==a&&a.invalidKeys&&(this.invalidKeysError=e.t0.responseJSON.data.invalidKeys),e.t0;case 14:return e.prev=14,this.busy=!1,e.finish(14);case 17:case"end":return e.stop()}}),e,this,[[2,9,14,17]])}))),this.skip=(0,d.flow)(E().mark((function e(){var t,n;return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return this.busy=!0,e.prev=1,e.next=4,se({location:P,params:{slug:this.slug}});case 4:e.next=11;break;case 6:throw e.prev=6,e.t0=e.catch(1),console.log(e.t0),null!==(t=e.t0.responseJSON)&&void 0!==t&&null!==(n=t.data)&&void 0!==n&&n.invalidKeys&&(this.invalidKeysError=e.t0.responseJSON.data.invalidKeysError),e.t0;case 11:return e.prev=11,this.busy=!1,e.finish(11);case 14:case"end":return e.stop()}}),e,this,[[1,6,11,14]])}))),this.fromResponse(t),this.store=n}return(0,p.Z)(e,[{key:"licensedEntries",get:function(){return this.licenses.filter((function(e){return e.code}))}},{key:"unlicensedEntries",get:function(){return this.licenses.filter((function(e){return!e.code}))}},{key:"noUsageEntries",get:function(){return this.unlicensedEntries.filter((function(e){return e.noUsage}))}},{key:"modifiableEntries",get:function(){return this.unlicensedEntries.filter((function(e){return!e.programmatically}))}},{key:"isLicensed",get:function(){return 0===this.unlicensedEntries.length}},{key:"fromResponse",value:function(e){var t=this,n=e.licenses,r=(0,R.Z)(e,["licenses"]);(0,d.set)(this,r),this.licenses=[],null==n||n.forEach((function(e){t.licenses.push(new pe(e,t))}))}}]),e}(),L=(0,v.Z)(z.prototype,"busy",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:function(){return!1}}),M=(0,v.Z)(z.prototype,"slug",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),X=(0,v.Z)(z.prototype,"licenses",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),K=(0,v.Z)(z.prototype,"hasInteractedWithFormOnce",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),q=(0,v.Z)(z.prototype,"name",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),W=(0,v.Z)(z.prototype,"needsLicenseKeys",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),V=(0,v.Z)(z.prototype,"announcementsActive",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),B=(0,v.Z)(z.prototype,"allowsAutoUpdates",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),j=(0,v.Z)(z.prototype,"allowsTelemetry",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),H=(0,v.Z)(z.prototype,"allowsNewsletter",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),G=(0,v.Z)(z.prototype,"potentialNewsletterUser",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),J=(0,v.Z)(z.prototype,"privacyProvider",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),Y=(0,v.Z)(z.prototype,"privacyPolicy",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),$=(0,v.Z)(z.prototype,"accountSiteUrl",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),Q=(0,v.Z)(z.prototype,"licenseKeyHelpUrl",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),ee=(0,v.Z)(z.prototype,"checkUpdateLink",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),te=(0,v.Z)(z.prototype,"invalidKeysError",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),ne=(0,v.Z)(z.prototype,"showBlogName",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:function(){return!1}}),re=(0,v.Z)(z.prototype,"showNetworkWideUpdateIssueNotice",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:function(){return!1}}),(0,v.Z)(z.prototype,"licensedEntries",[d.computed],Object.getOwnPropertyDescriptor(z.prototype,"licensedEntries"),z.prototype),(0,v.Z)(z.prototype,"unlicensedEntries",[d.computed],Object.getOwnPropertyDescriptor(z.prototype,"unlicensedEntries"),z.prototype),(0,v.Z)(z.prototype,"noUsageEntries",[d.computed],Object.getOwnPropertyDescriptor(z.prototype,"noUsageEntries"),z.prototype),(0,v.Z)(z.prototype,"modifiableEntries",[d.computed],Object.getOwnPropertyDescriptor(z.prototype,"modifiableEntries"),z.prototype),(0,v.Z)(z.prototype,"isLicensed",[d.computed],Object.getOwnPropertyDescriptor(z.prototype,"isLicensed"),z.prototype),(0,v.Z)(z.prototype,"fromResponse",[d.action],Object.getOwnPropertyDescriptor(z.prototype,"fromResponse"),z.prototype),z),me={path:"/plugin-update/:slug",method:m.RouteHttpVerb.GET},he=(ae=function(){function e(t){(0,u.Z)(this,e),(0,h.Z)(this,"busy",ie,this),(0,h.Z)(this,"modalPlugin",le,this),(0,h.Z)(this,"pluginUpdates",oe,this),this.rootStore=void 0,this.showInModal=(0,d.flow)(E().mark((function e(t){return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return this.modalPlugin=t,e.prev=1,e.next=4,this.fetchPluginUpdate(t);case 4:e.next=10;break;case 6:throw e.prev=6,e.t0=e.catch(1),console.log(e.t0),e.t0;case 10:case"end":return e.stop()}}),e,this,[[1,6]])}))),this.fetchPluginUpdate=(0,d.flow)(E().mark((function e(t){var n,r;return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return this.busy=!0,e.prev=1,e.next=4,se({location:me,params:{slug:t}});case 4:return n=e.sent,r=new de(n,this),this.pluginUpdates.set(t,r),e.abrupt("return",r);case 10:throw e.prev=10,e.t0=e.catch(1),console.log(e.t0),e.t0;case 14:return e.prev=14,this.busy=!1,e.finish(14);case 17:case"end":return e.stop()}}),e,this,[[1,10,14,17]])}))),this.rootStore=t}return(0,p.Z)(e,[{key:"hideModal",value:function(){this.modalPlugin=void 0}}]),e}(),ie=(0,v.Z)(ae.prototype,"busy",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:function(){return!1}}),le=(0,v.Z)(ae.prototype,"modalPlugin",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),oe=(0,v.Z)(ae.prototype,"pluginUpdates",[d.observable],{configurable:!0,enumerable:!0,writable:!0,initializer:function(){return new Map}}),(0,v.Z)(ae.prototype,"hideModal",[d.action],Object.getOwnPropertyDescriptor(ae.prototype,"hideModal"),ae.prototype),ae);(0,d.configure)({enforceActions:"always"});var fe=function(){function e(){(0,u.Z)(this,e),this.optionStore=void 0,this.pluginUpdateStore=void 0,this.contextMemo=void 0,this.optionStore=new y(this),this.pluginUpdateStore=new he(this)}return(0,p.Z)(e,[{key:"context",get:function(){return this.contextMemo?this.contextMemo:this.contextMemo=(0,m.createContextFactory)(this)}}],[{key:"StoreProvider",get:function(){return e.get.context.StoreProvider}},{key:"get",get:function(){return e.me?e.me:e.me=new e}}]),e}();fe.me=void 0;var ge,be=function(){return fe.get.context.useStores()},ve=function(e){var t=e.children;return React.createElement(o.ZP,{prefixCls:"rpm-wpc-antd"},React.createElement(fe.StoreProvider,null,t))},ye=n(7938),we=n(7228),Ee=n(7363),Re=n(3500),Ze=n(2947),ke=n(5250),Pe=n(5744),Ue=n(2780),Se=n(1171),Oe=n(8911);function Ne(){return ge||(ge=(0,m.createLocalizationFactory)("".concat("devowl-wp","-").concat("real-product-manager-wp-client")))}var Ie=function(){var e;return(e=Ne()).__.apply(e,arguments)},xe=function(){var e;return(e=Ne())._i.apply(e,arguments)},Te=n(5056),_e={path:"/feedback/:slug",method:m.RouteHttpVerb.POST},Ae={labelCol:{span:24},wrapperCol:{span:24}},Fe={marginBottom:8},De=function(e){var t=e.initialValues,n=void 0===t?{}:t,r=e.plugin,a=e.name,i=e.privacyPolicy,l=e.privacyProvider,o=e.onClose,u=e.onDeactivate,p=(0,Ee.useMemo)((function(){return{"upgrade-to-pro":Ie("Upgrade to PRO Version"),"not-working":Ie("Plugin does not work"),"missing-features":Ie("Not the features I want"),incompatible:Ie("Incompatible with themes/plugins"),"missing-doc":Ie("Lack of documentation"),"found-better-plugin":Ie("Found a better plugin"),temp:Ie("Temporary deactivation"),other:Ie("Other")}}),[]),d=Re.Z.useForm(),m=(0,we.Z)(d,1)[0],h="license-form-".concat(r),f=(0,Ee.useState)(!0),g=(0,we.Z)(f,2),b=g[0],v=g[1],y=(0,Ee.useState)(!1),w=(0,we.Z)(y,2),R=w[0],Z=w[1],k=(0,Ee.useCallback)((function(){window.confirm(Ie("Are you sure you want to leave the feedback form?"))&&v(!1)}),[]),P=(0,Ee.useCallback)(function(){var e=(0,ye.Z)(E().mark((function e(t){var n,a,i,l,o,c,p,d,m,h,f,g,b,v,y,w,R,k;return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=(n=t).reason,i=void 0===a?"other":a,l=n.note,o=void 0===l?"":l,c=n.email,p=void 0===c?"":c,d=n.name,m=void 0===d?"":d,e.prev=1,Z(!0),e.next=5,se({location:_e,params:{slug:r},request:{reason:i,note:o,email:p,name:p?m:""}});case 5:null==u||u(),e.next=18;break;case 8:if(e.prev=8,e.t0=e.catch(1),b=e.t0,v=b.responseJSON,y=null==v||null===(h=v.data)||void 0===h||null===(f=h.body)||void 0===f||null===(g=f[0])||void 0===g?void 0:g.code,!(["DeactivationFeedbackAlreadyGiven","DeactivationFeedbackMightBeSpam"].indexOf(y)>-1)&&y){e.next=17;break}return null==u||u(),e.abrupt("return");case 17:s.ZP.error(null==v||null===(w=v.data)||void 0===w||null===(R=w.body)||void 0===R||null===(k=R[0])||void 0===k?void 0:k.message);case 18:return e.prev=18,Z(!1),e.finish(18);case 21:case"end":return e.stop()}}),e,null,[[1,8,18,21]])})));return function(t){return e.apply(this,arguments)}}(),[m,r]);return React.createElement(Ze.Z,{afterClose:o,onCancel:k,visible:b,footer:[React.createElement(ke.Z,{key:"skip",type:"default",onClick:u,className:"alignleft",disabled:R},React.createElement("b",null,Ie("Skip & Deactivate"))),React.createElement(ke.Z,{key:"submit",type:"primary",htmlType:"submit",form:h,disabled:R},Ie("Deactivate"))],title:React.createElement(React.Fragment,null,React.createElement(Te.Z,{twoToneColor:"#eb2f96"})," ",Ie("Too bad you are leaving"))},React.createElement(Pe.Z,{spinning:R},React.createElement(Re.Z,(0,c.Z)({name:h,id:h,form:m},Ae,{onFinish:P,initialValues:n}),React.createElement(Re.Z.Item,{name:"reason",label:React.createElement(React.Fragment,null,Ie("Please give us feedback why you deactivate %s.",a)),style:Fe,required:!0,rules:[{required:!0,message:Ie("Please provide a reason!")}]},React.createElement(Ue.ZP.Group,null,Object.keys(p).map((function(e){return React.createElement(Ue.ZP,{key:e,value:e,style:{width:"calc(50% - 8px)",float:"left"}},p[e])})))),React.createElement(Re.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.reason!==t.reason}},(function(e){return!!(0,e.getFieldValue)("reason")&&React.createElement(React.Fragment,null,React.createElement(Re.Z.Item,{label:Ie("What could we do better?"),name:"note",style:Fe},React.createElement(Se.Z.TextArea,{autoSize:{minRows:3}})),React.createElement(Re.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.answerTerms!==t.answerTerms}},(function(e){var t=e.getFieldValue;return!!t("reason")&&React.createElement(React.Fragment,null,React.createElement(Re.Z.Item,{name:"email",label:Ie("Email for answer/solution"),style:Fe,rules:[{type:"email",required:t("answerTerms"),message:Ie("Please provide a valid e-mail address!")}]},React.createElement(Se.Z,null)),React.createElement(Re.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.email!==t.email}},(function(e){var t=e.getFieldValue;return React.createElement(React.Fragment,null,!!t("email")&&React.createElement(Re.Z.Item,{name:"name",label:Ie("Name"),required:!0,style:Fe,rules:[{required:!0,message:Ie("Please provide a name!")}]},React.createElement(Se.Z,null)),React.createElement(Re.Z.Item,{name:"answerTerms",valuePropName:"checked",required:!0,rules:[{type:"boolean",required:!!t("email"),transform:function(e){return e||void 0},message:Ie("Please confirm that you have checked the privacy policy.")}],style:Fe},React.createElement(Oe.Z,{style:{zoom:.8}},xe(Ie("I would like to receive a response to my request. For this purpose, I agree to the data processing of my feedback and my e-mail address. I have read and acknowledge the %s {{a}}Privacy Policy{{/a}}.",l),{a:React.createElement("a",{href:i,target:"_blank",rel:"noreferrer"})}))))})))})))})),React.createElement(Re.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.note!==t.note||e.answerTerms!==t.answerTerms}},(function(e){var t=e.getFieldValue,n=t("answerTerms")||!1,r=t("note")||"";return n?null:r.split(" ").length>=5?React.createElement("div",{className:"notice notice-info inline below-h2 notice-alt",style:{margin:0}},React.createElement("p",null,Ie("Allow us to reply to you by email and we will get back to you as soon as possible!"))):React.createElement("p",{className:"description",style:{marginTop:5}},xe(Ie("Are there any problems with the setup or use of the plugin? Maybe we can help you in the support. {{a}}Contact support{{/a}}."),{a:React.createElement("a",{href:Ie("https://devowl.io/support/"),target:"_blank",rel:"noreferrer"})}))})))))};function Ce(){document.addEventListener("click",(function(e){var t=fe.get.optionStore.others,n=t.names,r=t.currentUserFullName,a=null==e?void 0:e.target;for(var i in n){var o=n[i].plugin;if(a.matches('tr[data-plugin="'.concat(o,'"] a[href*="action=deactivate"]'))&&"break"===function(){var t=document.createElement("div");return document.body.appendChild(t),(0,l.render)(React.createElement(ve,null,React.createElement(De,(0,c.Z)({},n[i],{initialValues:{name:r},plugin:i,onClose:function(){(0,l.unmountComponentAtNode)(t)},onDeactivate:function(){window.location.href=a.href}}))),t),e.preventDefault(),e.stopImmediatePropagation(),"break"}())break}}),!0)}var ze="data-rpm-wp-client-plugin-update";function Le(){document.addEventListener("click",(function(e){var t,n=null===(t=e.target)||void 0===t?void 0:t.getAttribute(ze);n&&(fe.get.pluginUpdateStore.showInModal(n),e.preventDefault())}))}var Me="rpm-wp-client-plugin-update-";function Xe(){var e=window.location.hash;if(e.startsWith("#".concat(Me))){var t=e.substr(Me.length+1);fe.get.pluginUpdateStore.showInModal(t),window.location.hash=""}}var Ke=n(3554),qe=n(2867),We=n(2711),Ve=n(8674),Be=(0,Ke.Pi)((function(e){var t=e.pluginUpdate,n=t.privacyProvider,r=t.privacyPolicy,a=t.allowsTelemetry,i=t.allowsAutoUpdates,l=t.allowsNewsletter;return React.createElement(React.Fragment,null,i&&React.createElement(Re.Z.Item,{name:"autoUpdates",valuePropName:"checked",style:Ye},React.createElement(Oe.Z,{style:{zoom:.8}},xe(Ie("Updates containing bug fixes and new features will be downloaded and installed automatically."),{a:React.createElement("a",{href:r,target:"_blank",rel:"noreferrer"})}))),React.createElement(Re.Z.Item,{name:"terms",valuePropName:"checked",required:!0,rules:[{type:"boolean",required:!0,transform:function(e){return e||void 0},message:Ie("Please confirm that you have read the privacy policy!")}],style:Ye},React.createElement(Oe.Z,{style:{zoom:.8}},xe(Ie("I allow to transfer technical data about this WordPress installation to the update server of %1$s and get latest announcements. This data is required for license activation and update functionality. I have read the {{a}}privacy policy{{/a}} of %1$s.",n),{a:React.createElement("a",{href:r,target:"_blank",rel:"noreferrer"})}))),a&&React.createElement(Re.Z.Item,{name:"telemetry",valuePropName:"checked",style:Ye},React.createElement(Oe.Z,{style:{zoom:.8}},xe(Ie("I allow telemetry data about the use of this WordPress plugin to be collected in accordance with the %1$s {{a}}privacy policy{{/a}}. This data does not include any personal information about users of the plugin. Collected data will be used to provide you with the best possible support and to improve the plugin.",n),{a:React.createElement("a",{href:r,target:"_blank",rel:"noreferrer"})}))),l&&React.createElement(Re.Z.Item,{name:"newsletter",valuePropName:"checked",style:Ye},React.createElement(Oe.Z,{style:{zoom:.8}},xe(Ie("I would like to receive the %1$s newsletter with WordPress news, sales and product offers (approx. 1-2 per month) by email. I have read the %1$s {{a}}privacy policy{{/a}}. I know that I can unsubscribe from the newsletter at any time.",n),{a:React.createElement("a",{href:r,target:"_blank",rel:"noreferrer"})}))),React.createElement(Re.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.newsletter!==t.newsletter}},(function(e){return(0,e.getFieldValue)("newsletter")&&React.createElement(React.Fragment,null,React.createElement(Re.Z.Item,{label:Ie("First name"),name:"firstName",style:Ye,required:!0,rules:[{required:!0,message:Ie("Please enter your first name!")}]},React.createElement(Se.Z,null)),React.createElement(Re.Z.Item,{label:Ie("Email"),name:"email",style:Ye,required:!0,rules:[{type:"email",required:!0,message:Ie("Please enter your email address!")}]},React.createElement(Se.Z,null)),React.createElement("div",{className:"notice notice-info inline below-h2 notice-alt",style:{margin:0}},React.createElement("p",null,Ie("Please note that we will send you a confirmation e-mail. Only when you have clicked on the activation link in the email will you receive the newsletter."))))})))})),je=n(2762),He=n(1294),Ge=function(e){var t=e.url,n=e.style,r=void 0===n?void 0:n,a=e.label,i=void 0===a?Ie("Learn more"):a,l=(0,We.Z)({cursor:"pointer"},r);return React.createElement(je.Z,{style:l,onClick:function(){return window.open(t,"_blank")}},React.createElement(He.Z,null)," ",i)},Je={labelCol:{span:24},wrapperCol:{span:24}},Ye={marginBottom:8},$e=(0,Ke.Pi)((function(e){var t=e.onSave,n=e.onFailure,r=e.footer,a=e.pluginUpdate,i=(0,Ee.useState)(!1),l=(0,we.Z)(i,2),o=l[0],u=l[1],p=a.busy,d=a.slug,m=a.allowsAutoUpdates,h=a.needsLicenseKeys,f=a.licenses,g=a.unlicensedEntries,b=a.noUsageEntries,v=a.modifiableEntries,y=a.invalidKeysError,w=a.accountSiteUrl,Z=a.licenseKeyHelpUrl,k=a.name,P=a.potentialNewsletterUser,U=P.firstName,S=P.email,O=a.showBlogName,N=a.showNetworkWideUpdateIssueNotice,I=f.length>1,x={licenses:f.map((function(e){var t,n=e.blog,r=e.code,a=e.installationType,i=e.hint,l=e.noUsage;return{blog:n,code:r||(i?null===(t=i.help.match(/(\w{8}-\w{4}-\w{4}-\w{4}-\w{12})|(\w{32})/))||void 0===t?void 0:t[0]:"")||"",installationType:a||"",noUsage:l}})),autoUpdates:m,terms:!1,telemetry:!1,newsletter:!1,firstName:U,email:S},T=Re.Z.useForm(),_=(0,we.Z)(T,1)[0],A=(0,Ee.useState)(b.length!==g.length),F=(0,we.Z)(A,2),D=F[0],C=F[1],z=(0,Ee.useCallback)(function(){var e=(0,ye.Z)(E().mark((function e(r){var i,l,o;return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return i=r.licenses,l=(0,R.Z)(r,["licenses"]),o=(0,We.Z)((0,We.Z)({},l),{},{licenses:JSON.stringify(h?i.filter((function(e){var t=e.blog,n=f.filter((function(e){return e.blog===t})),r=(0,we.Z)(n,1)[0];return g.indexOf(r)>-1})):void 0)}),e.prev=2,e.next=5,a.update(o);case 5:_.setFieldsValue({terms:!1,telemetry:!1,newsletter:!1}),s.ZP.success(Ie("Your license has been activated!")),null==t||t(),e.next=15;break;case 10:throw e.prev=10,e.t0=e.catch(2),a.invalidKeysError||s.ZP.error(e.t0.responseJSON.message),null==n||n(),e.t0;case 15:case"end":return e.stop()}}),e,null,[[2,10]])})));return function(t){return e.apply(this,arguments)}}(),[a,t,f,g,h]),L=(0,Ee.useCallback)(function(){var e=(0,ye.Z)(E().mark((function e(t){return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,z(t);case 3:e.next=7;break;case 5:e.prev=5,e.t0=e.catch(0);case 7:return e.prev=7,u(!1),e.finish(7);case 10:case"end":return e.stop()}}),e,null,[[0,5,7,10]])})));return function(t){return e.apply(this,arguments)}}(),[_,z,u]),M=(0,Ee.useCallback)((function(){u(!0),C(!0)}),[]);return React.createElement(Pe.Z,{spinning:p},g.length>0&&React.createElement(React.Fragment,null,React.createElement("p",{className:"description",style:{marginBottom:15}},h?Ie("Activate your %s PRO license to receive regular updates and support.",k):xe(Ie("To use all advantages of %s {{strong}}you need a free license{{/strong}}. After license activation you will receive answers to support requests and announcements in your plugin (e.g. also notices for discount actions of the PRO version).",k),{strong:React.createElement("strong",null)})),N&&React.createElement("div",{className:"notice notice-error inline below-h2 notice-alt",style:{margin:"0 0 10px 0"}},React.createElement("p",null,Ie("You are using a WordPress mulisite. Due to technical limitations of WordPress core, %s can receive automatic updates in WordPress multisites only if the plugin is enabled network-wide. You can enable the plugin network-wide, but still only license it for specific sites.",k)),React.createElement("p",null,Ie("Please enable %s network-wide or take care of regular updates manually! ",k))),React.createElement(Re.Z,(0,c.Z)({name:"license-form-".concat(d),id:"license-form-".concat(d),form:_},Je,{initialValues:x,onFinish:L,onFinishFailed:M,onChange:function(){C(!0)}}),h&&React.createElement(React.Fragment,null,React.createElement(Re.Z.List,{name:"licenses"},(function(e){return e.map((function(e,t){var n=_.getFieldValue(["licenses",e.name]).blog,r=f.filter((function(e){return e.blog===n})),a=(0,we.Z)(r,1)[0];if(-1===g.indexOf(a))return null;var i,l=a.busy,u=a.blogName,p=a.programmatically,d=a.host,m=null==y?void 0:y[n],h=o?{}:m||a.hint,b=!(null==m||!m.debug.errors.LicenseMaxUsagesReached);return"boolean"!=typeof h&&b&&(i=React.createElement("span",null,h.help," ",React.createElement(Ge,{url:Ie("https://devowl.io/knowledge-base/the-limit-of-activated-clients-for-this-license-has-already-been-reached/")}))),React.createElement(Pe.Z,{spinning:l,key:e.key},React.createElement(Re.Z.Item,{noStyle:!0,shouldUpdate:function(t,n){return t.licenses[e.key].noUsage!==n.licenses[e.key].noUsage}},(function(n){var r=(0,n.getFieldValue)(["licenses",e.key,"noUsage"]);return React.createElement(Re.Z.Item,(0,c.Z)({label:React.createElement("span",null,g.length>1||O?xe(Ie("Installation type and license key for {{strong}}%s{{/strong}}",u),{strong:React.createElement("strong",null)}):Ie("Installation type and license key")," ",React.createElement(Ge,{url:Z})),help:i},h,{required:!0,style:Ye}),!r&&React.createElement(React.Fragment,null,React.createElement(Re.Z.Item,{fieldKey:[e.fieldKey,"code"],name:[e.name,"code"],noStyle:!0,rules:[{pattern:/(^\w{8}-\w{4}-\w{4}-\w{4}-\w{12}$)|(^\w{32}$)/,required:!0,message:Ie("Please enter a valid license key!")}]},React.createElement(Se.Z,{placeholder:p?p.code:"XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX",disabled:!!p,addonBefore:React.createElement(Re.Z.Item,{fieldKey:[e.fieldKey,"installationType"],name:[e.name,"installationType"],noStyle:!0,rules:[{required:!0,message:Ie("Please choose an installation type!")}]},React.createElement(Ve.Z,{placeholder:Ie("Installation type"),disabled:!!p},React.createElement(Ve.Z.Option,{value:"",disabled:!0},p?"development"===p.type?Ie("Development"):Ie("Production"):Ie("Select installation type…")),React.createElement(Ve.Z.Option,{value:"production"},Ie("Production")),React.createElement(Ve.Z.Option,{value:"development"},Ie("Development"))))})),0===t&&React.createElement("p",{className:"description",style:{marginTop:5}},React.createElement("strong",null,Ie("What is an installation type?"))," ",Ie("You can use each license in both production and development environments.")," ",xe(Ie('Generally speaking, you use "{{strong}}Development{{/strong}}" when your site is not yet live, or it is a staging environment of your site. "{{strong}}Production{{/strong}}" is what you use once your site is live. You can change the installation-type at any time by deactivating the license and activate it again.'),{strong:React.createElement("strong",null)}))),I&&React.createElement(Re.Z.Item,{fieldKey:[e.fieldKey,"noUsage"],name:[e.name,"noUsage"],valuePropName:"checked",style:{marginTop:r?-25:0===t?-8:0,marginBottom:0}},React.createElement(Oe.Z,null,Ie("I do not want to license and use the plugin for this site within my multisite."))))})),p&&React.createElement("div",{className:"notice notice-warning inline below-h2 notice-alt",style:{margin:"0 0 10px 0"}},React.createElement("p",null,xe(Ie("This license cannot be activated manually because it is configured programmatically. That means you have used the {{a}}activation filter{{/a}} for host {{code}}%s{{/code}} (Blog ID: %d). Unfortunately, there went something wrong while activating the license.",d,n),{code:React.createElement("code",null),a:React.createElement("a",{href:"https://docs.devowl.io/real-cookie-banner/hooks/DevOwl_RealProductManager_License_Programmatic_$slug.html",target:"_blank",rel:"noreferrer"})})," ","•"," ",React.createElement("a",{className:"button-link",onClick:(0,ye.Z)(E().mark((function e(){return E().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,a.retry();case 3:a.hint&&s.ZP.error(a.hint.help),e.next=9;break;case 6:e.prev=6,e.t0=e.catch(0),s.ZP.error(e.t0.responseJSON.message);case 9:case"end":return e.stop()}}),e,null,[[0,6]])})))},Ie("Retry activation")))),b&&React.createElement("a",{href:w,target:"_blank",rel:"noreferrer",className:"button button-primary"},Ie("Manage licenses in the customer center")))}))})),React.createElement(qe.Z,{type:"horizontal",style:{margin:"10px 0"}})),v.length>0&&React.createElement(React.Fragment,null,React.createElement("div",{style:{display:D?"block":"none"}},React.createElement(Be,{pluginUpdate:a})),r))))})),Qe=n(6058),et=n(2491),tt=n(1652),nt=n(8875),rt=n(4551),at=(0,Ke.Pi)((function(e){var t=e.onDeactivate,n=e.pluginUpdate,r=n.licensedEntries,a=n.needsLicenseKeys;return React.createElement(React.Fragment,null,React.createElement(Qe.ZP,{itemLayout:"vertical",size:"small",dataSource:r,renderItem:function(e){var n=e.busy,r=e.installationType,i=e.blogName,l=e.code,o=e.remote,c=e.programmatically,u=e.host,p=e.blog;return React.createElement(Pe.Z,{spinning:n},React.createElement(Qe.ZP.Item,{style:{paddingLeft:0,paddingRight:0},actions:[a&&React.createElement(et.Z,{key:"installationType"},React.createElement(tt.Z,null),"production"===r?Ie("Production"):"development"===r?Ie("Development"):"n/a"),o&&React.createElement(et.Z,{key:"activatedAt"},React.createElement(nt.Z,null),Ie("Activated %s",new Date(o.licenseActivation.activatedAt).toLocaleString(document.documentElement.lang))),o&&React.createElement(et.Z,{key:"telemetryDataSharingOptIn"},React.createElement(rt.Z,null),o.licenseActivation.telemetryDataSharingOptIn?Ie("Telemetry data sharing enabled"):Ie("Telemetry data sharing disabled")),!c&&React.createElement("a",{key:"deactivate",className:"button-link",onClick:(0,ye.Z)(E().mark((function n(){return E().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return n.prev=0,n.next=3,e.deactivate();case 3:n.next=8;break;case 5:n.prev=5,n.t0=n.catch(0),s.ZP.error(n.t0.responseJSON.message);case 8:null==t||t(e);case 9:case"end":return n.stop()}}),n,null,[[0,5]])})))},Ie("Deactivate"))].filter(Boolean)},React.createElement(Qe.ZP.Item.Meta,{title:i,description:a?React.createElement(React.Fragment,null,Ie("Your license key"),": ",React.createElement("code",null,l)):Ie("Your installation is fully activated.")}),c&&React.createElement("div",{className:"notice notice-info inline below-h2 notice-alt",style:{margin:"0 0 10px 0"}},React.createElement("p",null,xe(Ie("This license cannot be deactivated manually because it is configured programmatically. That means you have used the {{a}}activation filter{{/a}} for host {{code}}%s{{/code}} (Blog ID: %d). Please remove the filter to deactivate the license!",u,p),{code:React.createElement("code",null),a:React.createElement("a",{href:"https://docs.devowl.io/real-cookie-banner/hooks/DevOwl_RealProductManager_License_Programmatic_$slug.html",target:"_blank",rel:"noreferrer"})})))))}}),React.createElement("p",{style:{textAlign:"right"}},React.createElement(Oe.Z,{disabled:n.busy,checked:n.announcementsActive,onChange:function(e){return n.setAnnouncementActive(e.target.checked)}},Ie("Show announcements for this plugin"))))})),it=(0,Ke.Pi)((function(){var e=(0,Ee.useState)(!1),t=(0,we.Z)(e,2),n=t[0],r=t[1],a=be().pluginUpdateStore,i=a.busy,l=a.modalPlugin,o=a.pluginUpdates,s=l?o.get(l):void 0,c=(null==s?void 0:s.unlicensedEntries.length)>0&&(null==s?void 0:s.licensedEntries.length)>0,u=(0,Ee.useCallback)((function(){if(n){var e=s.checkUpdateLink;e?window.location.href=e:window.location.reload()}else a.hideModal()}),[n,a,s]),p=(0,Ee.useCallback)((function(){return r(!0)}),[r]);return(0,Ee.useEffect)((function(){document.body.classList[l?"add":"remove"]("rpm-wpc-antd-modal-open")}),[l]),l?React.createElement(Ze.Z,{visible:!0,okButtonProps:{form:"license-form-".concat(null==s?void 0:s.slug),htmlType:"submit",style:{display:0===(null==s?void 0:s.unlicensedEntries.length)?"none":void 0}},cancelButtonProps:{style:{display:"none"}},onCancel:u,okText:Ie("Save"),title:s?React.createElement("span",{style:{fontWeight:"normal"}},React.createElement("strong",null,s.name,":")," ",Ie("License settings")):"",width:800},i||!s?React.createElement(Pe.Z,{spinning:!0}):React.createElement("div",null,c&&React.createElement(qe.Z,{type:"horizontal",orientation:"left",style:{marginTop:0}},Ie("Not yet licensed")),React.createElement($e,{onSave:p,pluginUpdate:s}),c&&React.createElement(qe.Z,{type:"horizontal",orientation:"left"},Ie("Already licensed")),s.licensedEntries.length>0&&React.createElement(at,{onDeactivate:p,pluginUpdate:s}))):null})),lt=(0,Ke.Pi)((function(e){var t=e.formProps,n=void 0===t?{}:t,r=e.listProps,a=void 0===r?{}:r,i=e.slug,l=be().pluginUpdateStore,o=l.busy,s=l.pluginUpdates.get(i),u=(null==s?void 0:s.unlicensedEntries.length)>0&&(null==s?void 0:s.licensedEntries.length)>0;return(0,Ee.useEffect)((function(){l.fetchPluginUpdate(i)}),[i]),o||!s?React.createElement(Pe.Z,{spinning:!0}):React.createElement("div",null,u&&React.createElement(qe.Z,{type:"horizontal",orientation:"left",style:{marginTop:0}},Ie("Not yet licensed")),React.createElement($e,(0,c.Z)({},n,{pluginUpdate:s})),u&&React.createElement(qe.Z,{type:"horizontal",orientation:"left"},Ie("Already licensed")),s.licensedEntries.length>0&&React.createElement(at,(0,c.Z)({},a,{pluginUpdate:s})))}));o.ZP.config({prefixCls:"rpm-wpc-antd"}),s.ZP.config({top:50}),Ce(),function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"complete";new Promise((function(n){document.readyState===t?(null==e||e(),n()):document.addEventListener("readystatechange",(function(){document.readyState===t&&(null==e||e(),n())}))}))}((function(){var e=document.createElement("div");document.body.appendChild(e),(0,l.render)(React.createElement(ve,null,React.createElement(it,null)),e),Le(),Xe()}))},7363:function(e){e.exports=React},1533:function(e){e.exports=ReactDOM},7821:function(e){e.exports=mobx}},n={};function r(e){var a=n[e];if(void 0!==a)return a.exports;var i=n[e]={id:e,loaded:!1,exports:{}};return t[e](i,i.exports,r),i.loaded=!0,i.exports}r.m=t,e=[],r.O=function(t,n,a,i){if(!n){var l=1/0;for(u=0;u<e.length;u++){n=e[u][0],a=e[u][1],i=e[u][2];for(var o=!0,s=0;s<n.length;s++)(!1&i||l>=i)&&Object.keys(r.O).every((function(e){return r.O[e](n[s])}))?n.splice(s--,1):(o=!1,i<l&&(l=i));if(o){e.splice(u--,1);var c=a();void 0!==c&&(t=c)}}return t}i=i||0;for(var u=e.length;u>0&&e[u-1][2]>i;u--)e[u]=e[u-1];e[u]=[n,a,i]},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,{a:t}),t},r.d=function(e,t){for(var n in t)r.o(t,n)&&!r.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},r.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.nmd=function(e){return e.paths=[],e.children||(e.children=[]),e},function(){var e={826:0};r.O.j=function(t){return 0===e[t]};var t=function(t,n){var a,i,l=n[0],o=n[1],s=n[2],c=0;if(l.some((function(t){return 0!==e[t]}))){for(a in o)r.o(o,a)&&(r.m[a]=o[a]);if(s)var u=s(r)}for(t&&t(n);c<l.length;c++)i=l[c],r.o(e,i)&&e[i]&&e[i][0](),e[l[c]]=0;return r.O(u)},n=self.webpackChunkdevowlWp_realProductManagerWpClient=self.webpackChunkdevowlWp_realProductManagerWpClient||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var a=r.O(void 0,[764],(function(){return r(3627)}));a=r.O(a),devowlWp_realProductManagerWpClient=a}();
//# sourceMappingURL=index.js.map