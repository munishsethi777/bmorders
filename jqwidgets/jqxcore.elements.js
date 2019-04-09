/*
jQWidgets v7.1.0 (2019-Feb)
Copyright (c) 2011-2019 jQWidgets.
License: https://jqwidgets.com/license/
*/
/* eslint-disable */

(function(){var c=[];var a=function(){var d=c;for(var e=0;e<d.length;e++){var g=d[e];var f=false;if(g.element.offsetWidth!==g.width){f=true}if(g.element.offsetHeight!==g.height){f=true}if(f){g.width=g.element.offsetWidth;g.height=g.element.offsetHeight;g.callback()}}};var b=setInterval(function(){a()},100);window.addResizeHandler=function(d,e){c.push({element:d,width:d.offsetWidth,height:d.offsetHeight,callback:e});return};window.removeResizeHandler=function(g){var d=c;var e=-1;for(var f=0;f<d.length;f++){if(d[f].element===g){e=f}}if(e>=0){c.splice(e,1)}return}})();(function(a){if(!a.jqx.elements){a.jqx.elements=new Array()}a.extend(a.event.special,{close:{noBubble:false},open:{noBubble:false}});window.JQXElements={settings:{}};a.jqx.elements.push({name:"jqxCalendar",template:"<div></div>",attributeSync:true,properties:{disabled:{attributeSync:false},width:{type:"length"},height:{type:"length"},min:{type:"date"},max:{type:"date"},value:{type:"date"}}});a.jqx.elements.push({name:"jqxButton",template:"<div></div>"});a.jqx.elements.push({name:"jqxButtonGroup",template:"<div></div>"});a.jqx.elements.push({name:"jqxBulletChart",template:"<div></div>"});a.jqx.elements.push({name:"jqxRadioButton",template:"<div></div>"});a.jqx.elements.push({name:"jqxCheckBox",template:"<div></div>"});a.jqx.elements.push({name:"jqxRepeatButton",template:"<button></button>"});a.jqx.elements.push({name:"jqxSwitchButton",template:"<div></div>"});a.jqx.elements.push({name:"jqxLinkButton",template:"<a></a>"});a.jqx.elements.push({name:"jqxToggleButton",template:"<button></button>"});a.jqx.elements.push({name:"jqxBarGauge",template:"<div></div>"});a.jqx.elements.push({name:"jqxChart",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxColorPicker",template:"<div></div>"});a.jqx.elements.push({name:"jqxComboBox",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxComplexInput",template:"<div><input/><div></div></div>",});a.jqx.elements.push({name:"jqxDraw",template:"<div></div>"});a.jqx.elements.push({name:"jqxDataTable",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxDateTimeInput",template:"<div></div>"});a.jqx.elements.push({name:"jqxDocking",template:"<div></div>"});a.jqx.elements.push({name:"jqxDockPanel",template:"<div></div>"});a.jqx.elements.push({name:"jqxDragDrop",template:"<div></div>"});a.jqx.elements.push({name:"jqxDropDownList",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxDropDownButton",template:"<div></div>"});a.jqx.elements.push({name:"jqxEditor",template:"<div></div>"});a.jqx.elements.push({name:"jqxExpander",template:"<div></div>"});a.jqx.elements.push({name:"jqxFileUpload",template:"<div></div>"});a.jqx.elements.push({name:"jqxFormattedInput",template:"<div><input/><div></div></div>",});a.jqx.elements.push({name:"jqxGauge",template:"<div></div>",propertyMap:{style:"backgroundStyle"}});a.jqx.elements.push({name:"jqxLinearGauge",template:"<div></div>",propertyMap:{style:"backgroundStyle"}});a.jqx.elements.push({name:"jqxGrid",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxPivotGrid",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxPivotDesigner",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxInput",template:"<input/>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxKanban",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxKnob",template:"<div></div>"});a.jqx.elements.push({name:"jqxLayout",template:"<div></div>"});a.jqx.elements.push({name:"jqxDockingLayout",template:"<div></div>"});a.jqx.elements.push({name:"jqxListBox",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxListMenu",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxLoader",template:"<div></div>"});a.jqx.elements.push({name:"jqxMaskedInput",template:"<input/>",});a.jqx.elements.push({name:"jqxMenu",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxNavBar",template:"<div></div>"});a.jqx.elements.push({name:"jqxNavigationBar",template:"<div></div>"});a.jqx.elements.push({name:"jqxNotification",template:"<div></div>",properties:{appendContainer:{type:"string"}}});a.jqx.elements.push({name:"jqxNumberInput",template:"<div></div>"});a.jqx.elements.push({name:"jqxPanel",template:"<div></div>"});a.jqx.elements.push({name:"jqxPasswordInput",template:"<input type='password'/>"});a.jqx.elements.push({name:"jqxPopover",template:"<div></div>",properties:{title:{type:"string"},arrowOffsetValue:{type:"number"},offset:{type:"json"},selector:{type:"string"},initContent:{type:"object"}}});a.jqx.elements.push({name:"jqxProgressBar",template:"<div></div>"});a.jqx.elements.push({name:"jqxRangeSelector",template:"<div></div>"});a.jqx.elements.push({name:"jqxRating",tagName:"jqx-rating",template:"<div></div>"});a.jqx.elements.push({name:"jqxResponsivePanel",template:"<div></div>"});a.jqx.elements.push({name:"jqxRibbon",template:"<div></div>"});a.jqx.elements.push({name:"jqxScheduler",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxSlider",template:"<div></div>"});a.jqx.elements.push({name:"jqxScrollBar",template:"<div></div>"});a.jqx.elements.push({name:"jqxScrollView",template:"<div></div>"});a.jqx.elements.push({name:"jqxSortable",template:"<div></div>",propertyMap:{appendTo:"addTo"}});a.jqx.elements.push({name:"jqxSplitter",template:"<div></div>",properties:{panels:{type:"array"}}});a.jqx.elements.push({name:"jqxTabs",template:"<div></div>"});a.jqx.elements.push({name:"jqxTagCloud",template:"<div></div>"});a.jqx.elements.push({name:"jqxTextArea",template:"<div></div>"});a.jqx.elements.push({name:"jqxToolBar",template:"<div></div>"});a.jqx.elements.push({name:"jqxTooltip",tagName:"jqx-tool-tip",template:"<div></div>"});a.jqx.elements.push({name:"jqxTree",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxTreeGrid",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxTreeMap",template:"<div></div>",properties:{source:{attributeSync:false}}});a.jqx.elements.push({name:"jqxValidator",template:"<div></div>"});a.jqx.elements.push({name:"jqxWindow",template:"<div></div>"});if(document.registerElement){if(!Object.is){Object.is=function(b,c){if(b===c){return b!==0||1/b===1/c}else{return b!==b&&c!==c}}}a(document).ready(function(){a.each(a.jqx.elements,function(){var c=this.name;var j=this;if(!j.tagName){j.tagName=j.name.split(/(?=[A-Z])/).join("-").toLowerCase()}var g=Object.create(HTMLElement.prototype);g.name=c;g.instances=new Array();var i={};var f=(function(){var m={},n=function(q,p,r){if(m[q]===undefined){m[q]={}}m[q][p]=r},o=function(q,p){if(m[q]===undefined||m[q][p]===undefined){return undefined}else{return m[q][p]}},l=function(p){return m[p]};return{addAttributeConfig:n,getAttributeConfig:o,getAttributeList:l}}());if(!a.jqx["_"+c]){return true}var h=a.jqx["_"+c].prototype.defineInstance();if(c=="jqxDockingLayout"){h=a.extend(h,a.jqx._jqxLayout.prototype.defineInstance())}if(c=="jqxToggleButton"||c=="jqxRepeatButton"||c=="jqxLinkButton"){h=a.extend(h,a.jqx._jqxButton.prototype.defineInstance())}if(c=="jqxTreeGrid"){h=a.extend(h,a.jqx._jqxDataTable.prototype.defineInstance())}g.initElement=function(){var l=this;if(!h){console.log(c+" is undefined");return}a.each(h,function(o,n){var m="_"+o;l[m]=n})};if(!h){console.log(c+" is undefined");return}a.each(h,function(o,r){if(!j.properties){j.properties=[]}if(o.indexOf("_")>=0){return true}var p=j.properties[o];var q=o.split(/(?=[A-Z])/).join("-").toLowerCase();var t=typeof r;var n=(p&&p.attributeSync)||j.attributeSync;if(!p&&j.attributeSync===undefined){n=true}var s="_"+o;if(o==="width"||o==="height"){t="length"}if(p&&p.type){t=p.type}var m={defaultValue:r,type:t,propertyName:o,attributeSync:n};f.addAttributeConfig(j.tagName,q,Object.freeze(m));i[o]=q;var l=function(x){var w=this;this[s]=x;if(this.widget){if(j.propertyMap&&j.propertyMap[o]){o=j.propertyMap[o]}var y={};y[o]=x;this.widget[c](y);var v=i[o];var u=f.getAttributeConfig(j.tagName,v);if(u.attributeSync){w.isUpdatingAttribute=true;w.setAttributeTyped(v,u,x);w.isUpdatingAttribute=false}w.propertyUpdated(o,x)}else{this.initialSettings[o]=x}};if(j.propertyMap&&j.propertyMap[o]){o=j.propertyMap[o]}Object.defineProperty(g,o,{configurable:false,enumerable:true,get:function(){return this[s]},set:function(u){l.call(this,u)}})});g.getAttributeTyped=function(l,m){return this.attributeStringToTypedValue(l,m,this.getAttribute(l))};g.setAttributeTyped=function(l,o,n){var p,m;m=this.getAttributeTyped(l,o);p=this.typedValueToAttributeString(n);if(p===undefined){this.removeAttribute(l)}else{this.setAttribute(l,p)}};g.typedValueToAttributeString=function(m){var l=typeof m;if(l==="boolean"){if(m){return""}else{return undefined}}else{if(l==="number"){if(Object.is(m,-0)){return"-0"}else{return m.toString()}}else{if(l==="string"||l==="length"){return m}else{if(l==="object"){return JSON.stringify(m,function(o,n){if(typeof n==="number"){if(isFinite(n)===false){return n.toString()}else{if(Object.is(n,-0)){return"-0"}}}return n})}}}}};g.attributeStringToTypedValue=function(l,m,n){if(m.type==="boolean"){if(n===""||n===l||n==="true"){return true}else{return false}}else{if(m.type==="number"){if(n===null||n===undefined){return undefined}else{return parseFloat(n)}}else{if(m.type==="string"){if(n===null||n===undefined){return undefined}else{return n}}else{if(m.type==="length"){if(n===null){return null}if(n!==null&&n.indexOf("px")>=0){return parseFloat(n)}if(n!==null&&n.indexOf("%")>=0){return n}if(!isNaN(parseFloat(n))){return parseFloat(n)}return n}else{if(m.type==="json"||m.type==="array"){return JSON.parse(n.replace(/'/g,'"'))}else{if(m.type==="object"){return window.JQXElements.settings[n]||window[n]}}}}}}return undefined};g.createdCallback=function(){var l=this;l.isReady=false;l.initialSettings={};l.initElement()};g.setup=function(){var r=this;if(r.isReady){return}r.isReady=true;var r=this;var z=null;var x=null;var u,l,s;var n=[];var F=true;var y=f.getAttributeList(j.tagName);var E=r.settings||{};var m=r.initialSettings;var G=j.template;for(var o in y){if(y.hasOwnProperty(o)&&r.hasAttribute(o)){var C=y[o];var p=r.getAttributeTyped(o,C);var H;if(p===undefined){H=C.defaultValue}else{H=p}E[C.propertyName]=H}}s=r.attributes;for(var o in s){var B=s[o];if(B&&B.name){if(B.name.indexOf("on-")>=0){var w=B.value;var A="";if(w.indexOf("(")>=0){A=w.substring(0,w.indexOf("("))}n.push({name:B.name.substring(3),handler:A})}else{if(B.name.substring(0,2)==="on"){var w=B.value;var A="";if(w.indexOf("(")>=0){A=w.substring(0,w.indexOf("("))}n.push({name:B.name.substring(2),handler:A})}else{if(B.name.indexOf("(")>=0){var w=B.value;var A="";if(w.indexOf("(")>=0){A=w.substring(0,w.indexOf("("))}var q=B.name.replace("(","").replace(")","");n.push({name:q,handler:A})}}}}}var D=function(M){var J=document.createDocumentFragment();var P=document.createElement("div");J.appendChild(P);var O=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi;var K=/<([\w:]+)/;M=M.replace(O,"<$1></$2>");var I=(K.exec(M)||["",""])[1].toLowerCase();var L=[0,"",""];var N=L[0];P.innerHTML=L[1]+M+L[2];while(N--){P=P.lastChild}M=P.childNodes;P.parentNode.removeChild(P);D=M[0];return D}(G);u=D;var t=function(T){var J=false;if(c==="jqxDragDrop"||c==="jqxPopover"||c==="jqxResponsivePanel"||c==="jqxLoader"||c==="jqxWindow"||c==="jqxSortable"||c==="jqxDraw"||c==="jqxValidator"){J=true;r.style.overflow="visible"}if(c==="jqxExpander"||c==="jqxRibbon"||c==="jqxBulletChart"||c==="jqxComboBox"){r.style.overflow="visible"}if(!J){while(r.childNodes.length){u.appendChild(r.firstChild)}r.appendChild(u)}else{u=r}if(c==="jqxScrollBar"||c==="jqxNotification"){r.style.overflow="visible";r.style.borderLeftWidth="0px";r.style.borderRightWidth="0px";r.style.borderTopWidth="0px";r.style.borderBottomWidth="0px"}a.extend(E,T);var R=c.toLowerCase();if(G.indexOf("button")>=0||G.indexOf("input")==1||G.indexOf("textarea")>=0||R.indexOf("button")>=0||R.indexOf("checkbox")>=0||R.indexOf("radio")>=0){r.style.display="inline-block"}else{r.style.display="block"}var M=function(Z,aa){if(!F||J){return}if(typeof aa==="string"&&aa.indexOf("%")>=0){r.style[Z]=aa}else{if(typeof aa==="string"&&aa.indexOf("px")>=0){r.style[Z]=2+parseFloat(aa)+"px"}else{if(aa==="auto"){r.style[Z]=aa}else{if(aa){r.style[Z]=2+aa+"px"}else{if(r.style[Z]){r.style[Z]=null}}}}}};if(E.width){M("width",E.width)}if(E.height){M("height",E.height)}l=new jqxBaseFramework(r);l.data(r,"jqxWidget",{element:r});z=l.width();x=l.height();var Y=2;if(c==="jqxPivotDesigner"||c==="jqxPivotGrid"||c==="jqxChart"||c==="jqxMenu"||c==="jqxToolBar"){u.style.width=u.style.height="100%"}else{if(!J){if(z&&!E.width&&r.style.width!=="auto"){if(c==="jqxButton"||c==="jqxCheckBox"||c==="jqxToggleButton"||c==="jqxRadioButton"||c==="jqxRepeatButton"||c==="jqxLinkButton"){z+=30}E.width=z-Y}if(x&&!E.height&&r.style.height!=="auto"&&x!==r.firstChild.offsetHeight){E.height=x-Y}}}var I={};var L={};var N=Object.getOwnPropertyNames(a.jqx["_"+c].prototype);if(c=="jqxDockingLayout"){L=a.extend(L,Object.keys(a.jqx._jqxLayout.prototype));I=a.extend(I,a.jqx._jqxLayout.prototype)}if(c=="jqxToggleButton"||c=="jqxRepeatButton"||c=="jqxLinkButton"){L=a.extend(L,Object.keys(a.jqx._jqxButton.prototype));I=a.extend(I,a.jqx._jqxButton.prototype)}if(c=="jqxTreeGrid"){L=a.extend(L,Object.keys(a.jqx._jqxDataTable.prototype));I=a.extend(I,a.jqx._jqxDataTable.prototype)}I=a.extend(I,a.jqx["_"+c].prototype);L=a.extend(L,Object.getOwnPropertyNames(I));for(var Q in L){var W=L[Q];if(W.indexOf("_")>=0){continue}if(W==="base"||W==="baseType"){continue}if(W==="onmousemove"||W==="resize"||W==="scrollWidth"||W==="scrollHeight"||W==="constructor"||W==="createInstance"||W==="defineInstance"){continue}if(typeof I[W]!=="function"){continue}var O=function(ad,aa){var ab=Array.prototype.slice.call(arguments,2);var Z=r;var ac=function(){if(Z._isUpdating){return}if(a.event.triggered){return}if(!Z.widget){Z._isUpdating=true;var af=arguments;var ae=ad.apply(a(u).data().jqxWidget,ab.concat(Array.prototype.slice.call(af)));Z._isUpdating=false;return ae}if(-1===N.indexOf(aa)){var ae=ad.apply(Z.widget.data().jqxWidget.base,ab.concat(Array.prototype.slice.call(arguments)))}else{var ae=ad.apply(Z.widget.data().jqxWidget,ab.concat(Array.prototype.slice.call(arguments)))}Z._isUpdating=false;return ae};return ac};r[W]=O(I[W],W)}var S=r.widget=a(u)[c](E);if(E.ready){r._isUpdating=false;if(!S.data().jqxWidget._loading){if(!S.data().jqxWidget.isInitialized){E.ready()}}else{var K=setInterval(function(){if(!S.data().jqxWidget._loading){if(!S.data().jqxWidget.isInitialized){E.ready()}clearInterval(K)}},100)}}if(c==="jqxMaskedInput"||c==="jqxPasswordInput"||c==="jqxButtonGroup"||c==="jqxButton"||c==="jqxToggleButton"||c==="jqxRepeatButton"){r.firstChild.style.boxSizing="border-box"}r.propertyUpdated=function(Z,aa){if(Z==="width"||Z==="height"){M(Z,aa)}};if(!J){var X=S.data().jqxWidget;!X.base?X.host.addClass("jqx-element-container"):X.base.host.addClass("jqx-element-container");if(E.multiSelect){r.style.height="auto"}l.addClass("jqx-widget jqx-element");l.addClass("jqx-element-no-border");if(c==="jqxRangeSelector"||c=="jqxButtonGroup"){l.css("overflow","visible")}}for(var P=0;P<n.length;P++){var U=n[P];S.on(U.name,function(Z){if(!Z.args){Z.args={}}if(window.JQXElements.settings[U.handler]&&Z.args){window.JQXElements.settings[U.handler].apply(r,[Z])}else{if(window[U.handler]&&Z.args){window[U.handler].apply(r,[Z])}}})}var V=function(){if(J){return}F=false;z=l.width();x=l.height();var ac=0;if(c==="jqxChart"||c==="jqxPivotGrid"||c==="jqxPivotDesigner"||c==="jqxDraw"){S[0].style.width="100%";S[0].style.height="100%"}else{var ae=parseInt(S.css("padding-left"));var ab=parseInt(S.css("padding-right"));var ad=parseInt(S.css("padding-top"));var aa=parseInt(S.css("padding-bottom"));var Z=r.firstChild?window.getComputedStyle(r.firstChild):null;var af=true;if(!Z){return}ac=0;if(Z&&Z.boxSizing!=="border-box"){ac=2}if(r.autoheight||r.height===null||r.height==="auto"||r.multiSelect){af=false}if(c==="jqxBarGauge"){ac=0}S[c]({width:z-ac});if(af){S[c]({height:x-ac})}}F=true};if(!J){addResizeHandler(r,function(){V()})}};if(r.hasAttribute("settings")){var v=r.getAttribute("settings");m=window.JQXElements.settings[v]||window[v];if(m){a.each(m,function(J,I){r["_"+J]=I})}}if(r.hasAttribute("delayed-create")){r.isCreated=false;r.createElement=function(){if(r.isCreated){return}if(r.hasAttribute("settings")){t(m)}else{t(r.settings)}r.isCreated=true}}else{t(m)}};var b=g.addEventListener;var e=g.addEventListener;g.addEventListener=function(l,m){var n=this;if(n.widget&&n.widget.on){if(c==="jqxDragDrop"||c==="jqxPopover"||c==="jqxResponsivePanel"||c==="jqxLoader"||c==="jqxWindow"||c==="jqxSortable"||c==="jqxDraw"||c==="jqxValidator"){JQXLite(n.parentNode).on(l,m)}else{n.widget.on(l,m)}}else{b.apply(this,[l,m])}};g.removeEventListener=function(l,m){var n=this;if(n.widget&&n.widget.off){if(c==="jqxDragDrop"||c==="jqxPopover"||c==="jqxResponsivePanel"||c==="jqxLoader"||c==="jqxWindow"||c==="jqxSortable"||c==="jqxDraw"||c==="jqxValidator"){JQXLite(n.parentNode).off(l,m)}else{n.widget.off(l,m)}}else{e.apply(this,[l,m])}};g.attachedCallback=function(){var l=this;l.setup()};g.attributeChangedCallback=function(q,n,o){var r=this;var p=f.getAttributeConfig(j.tagName,q);if(!r.isUpdatingAttribute&&p){var l=r.getAttributeTyped(q,p);var m;if(l===undefined){if(currAttrConfig){m=currAttrConfig.defaultValue}else{return}}else{m=l}r[currAttrConfig.propertyName]=m}};var k=function(){var m=document.querySelectorAll(j.tagName);for(var l=0;l<m.length;l++){if(m[l].hasAttribute("tagHelper")){return true}}return false};if(k()){return}var d=document.registerElement(j.tagName,{prototype:g});return d})})}})(jqxBaseFramework);

