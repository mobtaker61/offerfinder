import{r as ps}from"./bootstrap.bundle.min-DZGkkIWZ.js";function Wr(e,t){return function(){return e.apply(t,arguments)}}const{toString:hs}=Object.prototype,{getPrototypeOf:En}=Object,ut=(e=>t=>{const n=hs.call(t);return e[n]||(e[n]=n.slice(8,-1).toLowerCase())})(Object.create(null)),$=e=>(e=e.toLowerCase(),t=>ut(t)===e),lt=e=>t=>typeof t===e,{isArray:_e}=Array,ke=lt("undefined");function gs(e){return e!==null&&!ke(e)&&e.constructor!==null&&!ke(e.constructor)&&P(e.constructor.isBuffer)&&e.constructor.isBuffer(e)}const Jr=$("ArrayBuffer");function ms(e){let t;return typeof ArrayBuffer<"u"&&ArrayBuffer.isView?t=ArrayBuffer.isView(e):t=e&&e.buffer&&Jr(e.buffer),t}const bs=lt("string"),P=lt("function"),Gr=lt("number"),ft=e=>e!==null&&typeof e=="object",_s=e=>e===!0||e===!1,Ge=e=>{if(ut(e)!=="object")return!1;const t=En(e);return(t===null||t===Object.prototype||Object.getPrototypeOf(t)===null)&&!(Symbol.toStringTag in e)&&!(Symbol.iterator in e)},ys=$("Date"),ws=$("File"),Es=$("Blob"),Ss=$("FileList"),vs=e=>ft(e)&&P(e.pipe),As=e=>{let t;return e&&(typeof FormData=="function"&&e instanceof FormData||P(e.append)&&((t=ut(e))==="formdata"||t==="object"&&P(e.toString)&&e.toString()==="[object FormData]"))},xs=$("URLSearchParams"),[Ts,Os,Cs,Is]=["ReadableStream","Request","Response","Headers"].map($),Rs=e=>e.trim?e.trim():e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,"");function Fe(e,t,{allOwnKeys:n=!1}={}){if(e===null||typeof e>"u")return;let r,i;if(typeof e!="object"&&(e=[e]),_e(e))for(r=0,i=e.length;r<i;r++)t.call(null,e[r],r,e);else{const o=n?Object.getOwnPropertyNames(e):Object.keys(e),s=o.length;let a;for(r=0;r<s;r++)a=o[r],t.call(null,e[a],a,e)}}function Xr(e,t){t=t.toLowerCase();const n=Object.keys(e);let r=n.length,i;for(;r-- >0;)if(i=n[r],t===i.toLowerCase())return i;return null}const te=typeof globalThis<"u"?globalThis:typeof self<"u"?self:typeof window<"u"?window:global,Yr=e=>!ke(e)&&e!==te;function Kt(){const{caseless:e}=Yr(this)&&this||{},t={},n=(r,i)=>{const o=e&&Xr(t,i)||i;Ge(t[o])&&Ge(r)?t[o]=Kt(t[o],r):Ge(r)?t[o]=Kt({},r):_e(r)?t[o]=r.slice():t[o]=r};for(let r=0,i=arguments.length;r<i;r++)arguments[r]&&Fe(arguments[r],n);return t}const Ds=(e,t,n,{allOwnKeys:r}={})=>(Fe(t,(i,o)=>{n&&P(i)?e[o]=Wr(i,n):e[o]=i},{allOwnKeys:r}),e),Ns=e=>(e.charCodeAt(0)===65279&&(e=e.slice(1)),e),ks=(e,t,n,r)=>{e.prototype=Object.create(t.prototype,r),e.prototype.constructor=e,Object.defineProperty(e,"super",{value:t.prototype}),n&&Object.assign(e.prototype,n)},Ps=(e,t,n,r)=>{let i,o,s;const a={};if(t=t||{},e==null)return t;do{for(i=Object.getOwnPropertyNames(e),o=i.length;o-- >0;)s=i[o],(!r||r(s,e,t))&&!a[s]&&(t[s]=e[s],a[s]=!0);e=n!==!1&&En(e)}while(e&&(!n||n(e,t))&&e!==Object.prototype);return t},Ms=(e,t,n)=>{e=String(e),(n===void 0||n>e.length)&&(n=e.length),n-=t.length;const r=e.indexOf(t,n);return r!==-1&&r===n},Bs=e=>{if(!e)return null;if(_e(e))return e;let t=e.length;if(!Gr(t))return null;const n=new Array(t);for(;t-- >0;)n[t]=e[t];return n},$s=(e=>t=>e&&t instanceof e)(typeof Uint8Array<"u"&&En(Uint8Array)),Fs=(e,t)=>{const r=(e&&e[Symbol.iterator]).call(e);let i;for(;(i=r.next())&&!i.done;){const o=i.value;t.call(e,o[0],o[1])}},Ls=(e,t)=>{let n;const r=[];for(;(n=e.exec(t))!==null;)r.push(n);return r},js=$("HTMLFormElement"),Hs=e=>e.toLowerCase().replace(/[-_\s]([a-z\d])(\w*)/g,function(n,r,i){return r.toUpperCase()+i}),tr=(({hasOwnProperty:e})=>(t,n)=>e.call(t,n))(Object.prototype),Us=$("RegExp"),Zr=(e,t)=>{const n=Object.getOwnPropertyDescriptors(e),r={};Fe(n,(i,o)=>{let s;(s=t(i,o,e))!==!1&&(r[o]=s||i)}),Object.defineProperties(e,r)},qs=e=>{Zr(e,(t,n)=>{if(P(e)&&["arguments","caller","callee"].indexOf(n)!==-1)return!1;const r=e[n];if(P(r)){if(t.enumerable=!1,"writable"in t){t.writable=!1;return}t.set||(t.set=()=>{throw Error("Can not rewrite read-only method '"+n+"'")})}})},Ks=(e,t)=>{const n={},r=i=>{i.forEach(o=>{n[o]=!0})};return _e(e)?r(e):r(String(e).split(t)),n},Vs=()=>{},zs=(e,t)=>e!=null&&Number.isFinite(e=+e)?e:t;function Ws(e){return!!(e&&P(e.append)&&e[Symbol.toStringTag]==="FormData"&&e[Symbol.iterator])}const Js=e=>{const t=new Array(10),n=(r,i)=>{if(ft(r)){if(t.indexOf(r)>=0)return;if(!("toJSON"in r)){t[i]=r;const o=_e(r)?[]:{};return Fe(r,(s,a)=>{const c=n(s,i+1);!ke(c)&&(o[a]=c)}),t[i]=void 0,o}}return r};return n(e,0)},Gs=$("AsyncFunction"),Xs=e=>e&&(ft(e)||P(e))&&P(e.then)&&P(e.catch),Qr=((e,t)=>e?setImmediate:t?((n,r)=>(te.addEventListener("message",({source:i,data:o})=>{i===te&&o===n&&r.length&&r.shift()()},!1),i=>{r.push(i),te.postMessage(n,"*")}))(`axios@${Math.random()}`,[]):n=>setTimeout(n))(typeof setImmediate=="function",P(te.postMessage)),Ys=typeof queueMicrotask<"u"?queueMicrotask.bind(te):typeof process<"u"&&process.nextTick||Qr,f={isArray:_e,isArrayBuffer:Jr,isBuffer:gs,isFormData:As,isArrayBufferView:ms,isString:bs,isNumber:Gr,isBoolean:_s,isObject:ft,isPlainObject:Ge,isReadableStream:Ts,isRequest:Os,isResponse:Cs,isHeaders:Is,isUndefined:ke,isDate:ys,isFile:ws,isBlob:Es,isRegExp:Us,isFunction:P,isStream:vs,isURLSearchParams:xs,isTypedArray:$s,isFileList:Ss,forEach:Fe,merge:Kt,extend:Ds,trim:Rs,stripBOM:Ns,inherits:ks,toFlatObject:Ps,kindOf:ut,kindOfTest:$,endsWith:Ms,toArray:Bs,forEachEntry:Fs,matchAll:Ls,isHTMLForm:js,hasOwnProperty:tr,hasOwnProp:tr,reduceDescriptors:Zr,freezeMethods:qs,toObjectSet:Ks,toCamelCase:Hs,noop:Vs,toFiniteNumber:zs,findKey:Xr,global:te,isContextDefined:Yr,isSpecCompliantForm:Ws,toJSONObject:Js,isAsyncFn:Gs,isThenable:Xs,setImmediate:Qr,asap:Ys};function y(e,t,n,r,i){Error.call(this),Error.captureStackTrace?Error.captureStackTrace(this,this.constructor):this.stack=new Error().stack,this.message=e,this.name="AxiosError",t&&(this.code=t),n&&(this.config=n),r&&(this.request=r),i&&(this.response=i,this.status=i.status?i.status:null)}f.inherits(y,Error,{toJSON:function(){return{message:this.message,name:this.name,description:this.description,number:this.number,fileName:this.fileName,lineNumber:this.lineNumber,columnNumber:this.columnNumber,stack:this.stack,config:f.toJSONObject(this.config),code:this.code,status:this.status}}});const ei=y.prototype,ti={};["ERR_BAD_OPTION_VALUE","ERR_BAD_OPTION","ECONNABORTED","ETIMEDOUT","ERR_NETWORK","ERR_FR_TOO_MANY_REDIRECTS","ERR_DEPRECATED","ERR_BAD_RESPONSE","ERR_BAD_REQUEST","ERR_CANCELED","ERR_NOT_SUPPORT","ERR_INVALID_URL"].forEach(e=>{ti[e]={value:e}});Object.defineProperties(y,ti);Object.defineProperty(ei,"isAxiosError",{value:!0});y.from=(e,t,n,r,i,o)=>{const s=Object.create(ei);return f.toFlatObject(e,s,function(c){return c!==Error.prototype},a=>a!=="isAxiosError"),y.call(s,e.message,t,n,r,i),s.cause=e,s.name=e.name,o&&Object.assign(s,o),s};const Zs=null;function Vt(e){return f.isPlainObject(e)||f.isArray(e)}function ni(e){return f.endsWith(e,"[]")?e.slice(0,-2):e}function nr(e,t,n){return e?e.concat(t).map(function(i,o){return i=ni(i),!n&&o?"["+i+"]":i}).join(n?".":""):t}function Qs(e){return f.isArray(e)&&!e.some(Vt)}const ea=f.toFlatObject(f,{},null,function(t){return/^is[A-Z]/.test(t)});function dt(e,t,n){if(!f.isObject(e))throw new TypeError("target must be an object");t=t||new FormData,n=f.toFlatObject(n,{metaTokens:!0,dots:!1,indexes:!1},!1,function(b,d){return!f.isUndefined(d[b])});const r=n.metaTokens,i=n.visitor||l,o=n.dots,s=n.indexes,c=(n.Blob||typeof Blob<"u"&&Blob)&&f.isSpecCompliantForm(t);if(!f.isFunction(i))throw new TypeError("visitor must be a function");function u(g){if(g===null)return"";if(f.isDate(g))return g.toISOString();if(!c&&f.isBlob(g))throw new y("Blob is not supported. Use a Buffer instead.");return f.isArrayBuffer(g)||f.isTypedArray(g)?c&&typeof Blob=="function"?new Blob([g]):Buffer.from(g):g}function l(g,b,d){let m=g;if(g&&!d&&typeof g=="object"){if(f.endsWith(b,"{}"))b=r?b:b.slice(0,-2),g=JSON.stringify(g);else if(f.isArray(g)&&Qs(g)||(f.isFileList(g)||f.endsWith(b,"[]"))&&(m=f.toArray(g)))return b=ni(b),m.forEach(function(E,x){!(f.isUndefined(E)||E===null)&&t.append(s===!0?nr([b],x,o):s===null?b:b+"[]",u(E))}),!1}return Vt(g)?!0:(t.append(nr(d,b,o),u(g)),!1)}const p=[],h=Object.assign(ea,{defaultVisitor:l,convertValue:u,isVisitable:Vt});function _(g,b){if(!f.isUndefined(g)){if(p.indexOf(g)!==-1)throw Error("Circular reference detected in "+b.join("."));p.push(g),f.forEach(g,function(m,w){(!(f.isUndefined(m)||m===null)&&i.call(t,m,f.isString(w)?w.trim():w,b,h))===!0&&_(m,b?b.concat(w):[w])}),p.pop()}}if(!f.isObject(e))throw new TypeError("data must be an object");return _(e),t}function rr(e){const t={"!":"%21","'":"%27","(":"%28",")":"%29","~":"%7E","%20":"+","%00":"\0"};return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g,function(r){return t[r]})}function Sn(e,t){this._pairs=[],e&&dt(e,this,t)}const ri=Sn.prototype;ri.append=function(t,n){this._pairs.push([t,n])};ri.toString=function(t){const n=t?function(r){return t.call(this,r,rr)}:rr;return this._pairs.map(function(i){return n(i[0])+"="+n(i[1])},"").join("&")};function ta(e){return encodeURIComponent(e).replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}function ii(e,t,n){if(!t)return e;const r=n&&n.encode||ta;f.isFunction(n)&&(n={serialize:n});const i=n&&n.serialize;let o;if(i?o=i(t,n):o=f.isURLSearchParams(t)?t.toString():new Sn(t,n).toString(r),o){const s=e.indexOf("#");s!==-1&&(e=e.slice(0,s)),e+=(e.indexOf("?")===-1?"?":"&")+o}return e}class ir{constructor(){this.handlers=[]}use(t,n,r){return this.handlers.push({fulfilled:t,rejected:n,synchronous:r?r.synchronous:!1,runWhen:r?r.runWhen:null}),this.handlers.length-1}eject(t){this.handlers[t]&&(this.handlers[t]=null)}clear(){this.handlers&&(this.handlers=[])}forEach(t){f.forEach(this.handlers,function(r){r!==null&&t(r)})}}const oi={silentJSONParsing:!0,forcedJSONParsing:!0,clarifyTimeoutError:!1},na=typeof URLSearchParams<"u"?URLSearchParams:Sn,ra=typeof FormData<"u"?FormData:null,ia=typeof Blob<"u"?Blob:null,oa={isBrowser:!0,classes:{URLSearchParams:na,FormData:ra,Blob:ia},protocols:["http","https","file","blob","url","data"]},vn=typeof window<"u"&&typeof document<"u",zt=typeof navigator=="object"&&navigator||void 0,sa=vn&&(!zt||["ReactNative","NativeScript","NS"].indexOf(zt.product)<0),aa=typeof WorkerGlobalScope<"u"&&self instanceof WorkerGlobalScope&&typeof self.importScripts=="function",ca=vn&&window.location.href||"http://localhost",ua=Object.freeze(Object.defineProperty({__proto__:null,hasBrowserEnv:vn,hasStandardBrowserEnv:sa,hasStandardBrowserWebWorkerEnv:aa,navigator:zt,origin:ca},Symbol.toStringTag,{value:"Module"})),I={...ua,...oa};function la(e,t){return dt(e,new I.classes.URLSearchParams,Object.assign({visitor:function(n,r,i,o){return I.isNode&&f.isBuffer(n)?(this.append(r,n.toString("base64")),!1):o.defaultVisitor.apply(this,arguments)}},t))}function fa(e){return f.matchAll(/\w+|\[(\w*)]/g,e).map(t=>t[0]==="[]"?"":t[1]||t[0])}function da(e){const t={},n=Object.keys(e);let r;const i=n.length;let o;for(r=0;r<i;r++)o=n[r],t[o]=e[o];return t}function si(e){function t(n,r,i,o){let s=n[o++];if(s==="__proto__")return!0;const a=Number.isFinite(+s),c=o>=n.length;return s=!s&&f.isArray(i)?i.length:s,c?(f.hasOwnProp(i,s)?i[s]=[i[s],r]:i[s]=r,!a):((!i[s]||!f.isObject(i[s]))&&(i[s]=[]),t(n,r,i[s],o)&&f.isArray(i[s])&&(i[s]=da(i[s])),!a)}if(f.isFormData(e)&&f.isFunction(e.entries)){const n={};return f.forEachEntry(e,(r,i)=>{t(fa(r),i,n,0)}),n}return null}function pa(e,t,n){if(f.isString(e))try{return(t||JSON.parse)(e),f.trim(e)}catch(r){if(r.name!=="SyntaxError")throw r}return(n||JSON.stringify)(e)}const Le={transitional:oi,adapter:["xhr","http","fetch"],transformRequest:[function(t,n){const r=n.getContentType()||"",i=r.indexOf("application/json")>-1,o=f.isObject(t);if(o&&f.isHTMLForm(t)&&(t=new FormData(t)),f.isFormData(t))return i?JSON.stringify(si(t)):t;if(f.isArrayBuffer(t)||f.isBuffer(t)||f.isStream(t)||f.isFile(t)||f.isBlob(t)||f.isReadableStream(t))return t;if(f.isArrayBufferView(t))return t.buffer;if(f.isURLSearchParams(t))return n.setContentType("application/x-www-form-urlencoded;charset=utf-8",!1),t.toString();let a;if(o){if(r.indexOf("application/x-www-form-urlencoded")>-1)return la(t,this.formSerializer).toString();if((a=f.isFileList(t))||r.indexOf("multipart/form-data")>-1){const c=this.env&&this.env.FormData;return dt(a?{"files[]":t}:t,c&&new c,this.formSerializer)}}return o||i?(n.setContentType("application/json",!1),pa(t)):t}],transformResponse:[function(t){const n=this.transitional||Le.transitional,r=n&&n.forcedJSONParsing,i=this.responseType==="json";if(f.isResponse(t)||f.isReadableStream(t))return t;if(t&&f.isString(t)&&(r&&!this.responseType||i)){const s=!(n&&n.silentJSONParsing)&&i;try{return JSON.parse(t)}catch(a){if(s)throw a.name==="SyntaxError"?y.from(a,y.ERR_BAD_RESPONSE,this,null,this.response):a}}return t}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,maxBodyLength:-1,env:{FormData:I.classes.FormData,Blob:I.classes.Blob},validateStatus:function(t){return t>=200&&t<300},headers:{common:{Accept:"application/json, text/plain, */*","Content-Type":void 0}}};f.forEach(["delete","get","head","post","put","patch"],e=>{Le.headers[e]={}});const ha=f.toObjectSet(["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"]),ga=e=>{const t={};let n,r,i;return e&&e.split(`
`).forEach(function(s){i=s.indexOf(":"),n=s.substring(0,i).trim().toLowerCase(),r=s.substring(i+1).trim(),!(!n||t[n]&&ha[n])&&(n==="set-cookie"?t[n]?t[n].push(r):t[n]=[r]:t[n]=t[n]?t[n]+", "+r:r)}),t},or=Symbol("internals");function Te(e){return e&&String(e).trim().toLowerCase()}function Xe(e){return e===!1||e==null?e:f.isArray(e)?e.map(Xe):String(e)}function ma(e){const t=Object.create(null),n=/([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;let r;for(;r=n.exec(e);)t[r[1]]=r[2];return t}const ba=e=>/^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim());function Tt(e,t,n,r,i){if(f.isFunction(r))return r.call(this,t,n);if(i&&(t=n),!!f.isString(t)){if(f.isString(r))return t.indexOf(r)!==-1;if(f.isRegExp(r))return r.test(t)}}function _a(e){return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g,(t,n,r)=>n.toUpperCase()+r)}function ya(e,t){const n=f.toCamelCase(" "+t);["get","set","has"].forEach(r=>{Object.defineProperty(e,r+n,{value:function(i,o,s){return this[r].call(this,t,i,o,s)},configurable:!0})})}let k=class{constructor(t){t&&this.set(t)}set(t,n,r){const i=this;function o(a,c,u){const l=Te(c);if(!l)throw new Error("header name must be a non-empty string");const p=f.findKey(i,l);(!p||i[p]===void 0||u===!0||u===void 0&&i[p]!==!1)&&(i[p||c]=Xe(a))}const s=(a,c)=>f.forEach(a,(u,l)=>o(u,l,c));if(f.isPlainObject(t)||t instanceof this.constructor)s(t,n);else if(f.isString(t)&&(t=t.trim())&&!ba(t))s(ga(t),n);else if(f.isHeaders(t))for(const[a,c]of t.entries())o(c,a,r);else t!=null&&o(n,t,r);return this}get(t,n){if(t=Te(t),t){const r=f.findKey(this,t);if(r){const i=this[r];if(!n)return i;if(n===!0)return ma(i);if(f.isFunction(n))return n.call(this,i,r);if(f.isRegExp(n))return n.exec(i);throw new TypeError("parser must be boolean|regexp|function")}}}has(t,n){if(t=Te(t),t){const r=f.findKey(this,t);return!!(r&&this[r]!==void 0&&(!n||Tt(this,this[r],r,n)))}return!1}delete(t,n){const r=this;let i=!1;function o(s){if(s=Te(s),s){const a=f.findKey(r,s);a&&(!n||Tt(r,r[a],a,n))&&(delete r[a],i=!0)}}return f.isArray(t)?t.forEach(o):o(t),i}clear(t){const n=Object.keys(this);let r=n.length,i=!1;for(;r--;){const o=n[r];(!t||Tt(this,this[o],o,t,!0))&&(delete this[o],i=!0)}return i}normalize(t){const n=this,r={};return f.forEach(this,(i,o)=>{const s=f.findKey(r,o);if(s){n[s]=Xe(i),delete n[o];return}const a=t?_a(o):String(o).trim();a!==o&&delete n[o],n[a]=Xe(i),r[a]=!0}),this}concat(...t){return this.constructor.concat(this,...t)}toJSON(t){const n=Object.create(null);return f.forEach(this,(r,i)=>{r!=null&&r!==!1&&(n[i]=t&&f.isArray(r)?r.join(", "):r)}),n}[Symbol.iterator](){return Object.entries(this.toJSON())[Symbol.iterator]()}toString(){return Object.entries(this.toJSON()).map(([t,n])=>t+": "+n).join(`
`)}get[Symbol.toStringTag](){return"AxiosHeaders"}static from(t){return t instanceof this?t:new this(t)}static concat(t,...n){const r=new this(t);return n.forEach(i=>r.set(i)),r}static accessor(t){const r=(this[or]=this[or]={accessors:{}}).accessors,i=this.prototype;function o(s){const a=Te(s);r[a]||(ya(i,s),r[a]=!0)}return f.isArray(t)?t.forEach(o):o(t),this}};k.accessor(["Content-Type","Content-Length","Accept","Accept-Encoding","User-Agent","Authorization"]);f.reduceDescriptors(k.prototype,({value:e},t)=>{let n=t[0].toUpperCase()+t.slice(1);return{get:()=>e,set(r){this[n]=r}}});f.freezeMethods(k);function Ot(e,t){const n=this||Le,r=t||n,i=k.from(r.headers);let o=r.data;return f.forEach(e,function(a){o=a.call(n,o,i.normalize(),t?t.status:void 0)}),i.normalize(),o}function ai(e){return!!(e&&e.__CANCEL__)}function ye(e,t,n){y.call(this,e??"canceled",y.ERR_CANCELED,t,n),this.name="CanceledError"}f.inherits(ye,y,{__CANCEL__:!0});function ci(e,t,n){const r=n.config.validateStatus;!n.status||!r||r(n.status)?e(n):t(new y("Request failed with status code "+n.status,[y.ERR_BAD_REQUEST,y.ERR_BAD_RESPONSE][Math.floor(n.status/100)-4],n.config,n.request,n))}function wa(e){const t=/^([-+\w]{1,25})(:?\/\/|:)/.exec(e);return t&&t[1]||""}function Ea(e,t){e=e||10;const n=new Array(e),r=new Array(e);let i=0,o=0,s;return t=t!==void 0?t:1e3,function(c){const u=Date.now(),l=r[o];s||(s=u),n[i]=c,r[i]=u;let p=o,h=0;for(;p!==i;)h+=n[p++],p=p%e;if(i=(i+1)%e,i===o&&(o=(o+1)%e),u-s<t)return;const _=l&&u-l;return _?Math.round(h*1e3/_):void 0}}function Sa(e,t){let n=0,r=1e3/t,i,o;const s=(u,l=Date.now())=>{n=l,i=null,o&&(clearTimeout(o),o=null),e.apply(null,u)};return[(...u)=>{const l=Date.now(),p=l-n;p>=r?s(u,l):(i=u,o||(o=setTimeout(()=>{o=null,s(i)},r-p)))},()=>i&&s(i)]}const et=(e,t,n=3)=>{let r=0;const i=Ea(50,250);return Sa(o=>{const s=o.loaded,a=o.lengthComputable?o.total:void 0,c=s-r,u=i(c),l=s<=a;r=s;const p={loaded:s,total:a,progress:a?s/a:void 0,bytes:c,rate:u||void 0,estimated:u&&a&&l?(a-s)/u:void 0,event:o,lengthComputable:a!=null,[t?"download":"upload"]:!0};e(p)},n)},sr=(e,t)=>{const n=e!=null;return[r=>t[0]({lengthComputable:n,total:e,loaded:r}),t[1]]},ar=e=>(...t)=>f.asap(()=>e(...t)),va=I.hasStandardBrowserEnv?((e,t)=>n=>(n=new URL(n,I.origin),e.protocol===n.protocol&&e.host===n.host&&(t||e.port===n.port)))(new URL(I.origin),I.navigator&&/(msie|trident)/i.test(I.navigator.userAgent)):()=>!0,Aa=I.hasStandardBrowserEnv?{write(e,t,n,r,i,o){const s=[e+"="+encodeURIComponent(t)];f.isNumber(n)&&s.push("expires="+new Date(n).toGMTString()),f.isString(r)&&s.push("path="+r),f.isString(i)&&s.push("domain="+i),o===!0&&s.push("secure"),document.cookie=s.join("; ")},read(e){const t=document.cookie.match(new RegExp("(^|;\\s*)("+e+")=([^;]*)"));return t?decodeURIComponent(t[3]):null},remove(e){this.write(e,"",Date.now()-864e5)}}:{write(){},read(){return null},remove(){}};function xa(e){return/^([a-z][a-z\d+\-.]*:)?\/\//i.test(e)}function Ta(e,t){return t?e.replace(/\/?\/$/,"")+"/"+t.replace(/^\/+/,""):e}function ui(e,t,n){let r=!xa(t);return e&&r||n==!1?Ta(e,t):t}const cr=e=>e instanceof k?{...e}:e;function ue(e,t){t=t||{};const n={};function r(u,l,p,h){return f.isPlainObject(u)&&f.isPlainObject(l)?f.merge.call({caseless:h},u,l):f.isPlainObject(l)?f.merge({},l):f.isArray(l)?l.slice():l}function i(u,l,p,h){if(f.isUndefined(l)){if(!f.isUndefined(u))return r(void 0,u,p,h)}else return r(u,l,p,h)}function o(u,l){if(!f.isUndefined(l))return r(void 0,l)}function s(u,l){if(f.isUndefined(l)){if(!f.isUndefined(u))return r(void 0,u)}else return r(void 0,l)}function a(u,l,p){if(p in t)return r(u,l);if(p in e)return r(void 0,u)}const c={url:o,method:o,data:o,baseURL:s,transformRequest:s,transformResponse:s,paramsSerializer:s,timeout:s,timeoutMessage:s,withCredentials:s,withXSRFToken:s,adapter:s,responseType:s,xsrfCookieName:s,xsrfHeaderName:s,onUploadProgress:s,onDownloadProgress:s,decompress:s,maxContentLength:s,maxBodyLength:s,beforeRedirect:s,transport:s,httpAgent:s,httpsAgent:s,cancelToken:s,socketPath:s,responseEncoding:s,validateStatus:a,headers:(u,l,p)=>i(cr(u),cr(l),p,!0)};return f.forEach(Object.keys(Object.assign({},e,t)),function(l){const p=c[l]||i,h=p(e[l],t[l],l);f.isUndefined(h)&&p!==a||(n[l]=h)}),n}const li=e=>{const t=ue({},e);let{data:n,withXSRFToken:r,xsrfHeaderName:i,xsrfCookieName:o,headers:s,auth:a}=t;t.headers=s=k.from(s),t.url=ii(ui(t.baseURL,t.url),e.params,e.paramsSerializer),a&&s.set("Authorization","Basic "+btoa((a.username||"")+":"+(a.password?unescape(encodeURIComponent(a.password)):"")));let c;if(f.isFormData(n)){if(I.hasStandardBrowserEnv||I.hasStandardBrowserWebWorkerEnv)s.setContentType(void 0);else if((c=s.getContentType())!==!1){const[u,...l]=c?c.split(";").map(p=>p.trim()).filter(Boolean):[];s.setContentType([u||"multipart/form-data",...l].join("; "))}}if(I.hasStandardBrowserEnv&&(r&&f.isFunction(r)&&(r=r(t)),r||r!==!1&&va(t.url))){const u=i&&o&&Aa.read(o);u&&s.set(i,u)}return t},Oa=typeof XMLHttpRequest<"u",Ca=Oa&&function(e){return new Promise(function(n,r){const i=li(e);let o=i.data;const s=k.from(i.headers).normalize();let{responseType:a,onUploadProgress:c,onDownloadProgress:u}=i,l,p,h,_,g;function b(){_&&_(),g&&g(),i.cancelToken&&i.cancelToken.unsubscribe(l),i.signal&&i.signal.removeEventListener("abort",l)}let d=new XMLHttpRequest;d.open(i.method.toUpperCase(),i.url,!0),d.timeout=i.timeout;function m(){if(!d)return;const E=k.from("getAllResponseHeaders"in d&&d.getAllResponseHeaders()),T={data:!a||a==="text"||a==="json"?d.responseText:d.response,status:d.status,statusText:d.statusText,headers:E,config:e,request:d};ci(function(L){n(L),b()},function(L){r(L),b()},T),d=null}"onloadend"in d?d.onloadend=m:d.onreadystatechange=function(){!d||d.readyState!==4||d.status===0&&!(d.responseURL&&d.responseURL.indexOf("file:")===0)||setTimeout(m)},d.onabort=function(){d&&(r(new y("Request aborted",y.ECONNABORTED,e,d)),d=null)},d.onerror=function(){r(new y("Network Error",y.ERR_NETWORK,e,d)),d=null},d.ontimeout=function(){let x=i.timeout?"timeout of "+i.timeout+"ms exceeded":"timeout exceeded";const T=i.transitional||oi;i.timeoutErrorMessage&&(x=i.timeoutErrorMessage),r(new y(x,T.clarifyTimeoutError?y.ETIMEDOUT:y.ECONNABORTED,e,d)),d=null},o===void 0&&s.setContentType(null),"setRequestHeader"in d&&f.forEach(s.toJSON(),function(x,T){d.setRequestHeader(T,x)}),f.isUndefined(i.withCredentials)||(d.withCredentials=!!i.withCredentials),a&&a!=="json"&&(d.responseType=i.responseType),u&&([h,g]=et(u,!0),d.addEventListener("progress",h)),c&&d.upload&&([p,_]=et(c),d.upload.addEventListener("progress",p),d.upload.addEventListener("loadend",_)),(i.cancelToken||i.signal)&&(l=E=>{d&&(r(!E||E.type?new ye(null,e,d):E),d.abort(),d=null)},i.cancelToken&&i.cancelToken.subscribe(l),i.signal&&(i.signal.aborted?l():i.signal.addEventListener("abort",l)));const w=wa(i.url);if(w&&I.protocols.indexOf(w)===-1){r(new y("Unsupported protocol "+w+":",y.ERR_BAD_REQUEST,e));return}d.send(o||null)})},Ia=(e,t)=>{const{length:n}=e=e?e.filter(Boolean):[];if(t||n){let r=new AbortController,i;const o=function(u){if(!i){i=!0,a();const l=u instanceof Error?u:this.reason;r.abort(l instanceof y?l:new ye(l instanceof Error?l.message:l))}};let s=t&&setTimeout(()=>{s=null,o(new y(`timeout ${t} of ms exceeded`,y.ETIMEDOUT))},t);const a=()=>{e&&(s&&clearTimeout(s),s=null,e.forEach(u=>{u.unsubscribe?u.unsubscribe(o):u.removeEventListener("abort",o)}),e=null)};e.forEach(u=>u.addEventListener("abort",o));const{signal:c}=r;return c.unsubscribe=()=>f.asap(a),c}},Ra=function*(e,t){let n=e.byteLength;if(n<t){yield e;return}let r=0,i;for(;r<n;)i=r+t,yield e.slice(r,i),r=i},Da=async function*(e,t){for await(const n of Na(e))yield*Ra(n,t)},Na=async function*(e){if(e[Symbol.asyncIterator]){yield*e;return}const t=e.getReader();try{for(;;){const{done:n,value:r}=await t.read();if(n)break;yield r}}finally{await t.cancel()}},ur=(e,t,n,r)=>{const i=Da(e,t);let o=0,s,a=c=>{s||(s=!0,r&&r(c))};return new ReadableStream({async pull(c){try{const{done:u,value:l}=await i.next();if(u){a(),c.close();return}let p=l.byteLength;if(n){let h=o+=p;n(h)}c.enqueue(new Uint8Array(l))}catch(u){throw a(u),u}},cancel(c){return a(c),i.return()}},{highWaterMark:2})},pt=typeof fetch=="function"&&typeof Request=="function"&&typeof Response=="function",fi=pt&&typeof ReadableStream=="function",ka=pt&&(typeof TextEncoder=="function"?(e=>t=>e.encode(t))(new TextEncoder):async e=>new Uint8Array(await new Response(e).arrayBuffer())),di=(e,...t)=>{try{return!!e(...t)}catch{return!1}},Pa=fi&&di(()=>{let e=!1;const t=new Request(I.origin,{body:new ReadableStream,method:"POST",get duplex(){return e=!0,"half"}}).headers.has("Content-Type");return e&&!t}),lr=64*1024,Wt=fi&&di(()=>f.isReadableStream(new Response("").body)),tt={stream:Wt&&(e=>e.body)};pt&&(e=>{["text","arrayBuffer","blob","formData","stream"].forEach(t=>{!tt[t]&&(tt[t]=f.isFunction(e[t])?n=>n[t]():(n,r)=>{throw new y(`Response type '${t}' is not supported`,y.ERR_NOT_SUPPORT,r)})})})(new Response);const Ma=async e=>{if(e==null)return 0;if(f.isBlob(e))return e.size;if(f.isSpecCompliantForm(e))return(await new Request(I.origin,{method:"POST",body:e}).arrayBuffer()).byteLength;if(f.isArrayBufferView(e)||f.isArrayBuffer(e))return e.byteLength;if(f.isURLSearchParams(e)&&(e=e+""),f.isString(e))return(await ka(e)).byteLength},Ba=async(e,t)=>{const n=f.toFiniteNumber(e.getContentLength());return n??Ma(t)},$a=pt&&(async e=>{let{url:t,method:n,data:r,signal:i,cancelToken:o,timeout:s,onDownloadProgress:a,onUploadProgress:c,responseType:u,headers:l,withCredentials:p="same-origin",fetchOptions:h}=li(e);u=u?(u+"").toLowerCase():"text";let _=Ia([i,o&&o.toAbortSignal()],s),g;const b=_&&_.unsubscribe&&(()=>{_.unsubscribe()});let d;try{if(c&&Pa&&n!=="get"&&n!=="head"&&(d=await Ba(l,r))!==0){let T=new Request(t,{method:"POST",body:r,duplex:"half"}),N;if(f.isFormData(r)&&(N=T.headers.get("content-type"))&&l.setContentType(N),T.body){const[L,ge]=sr(d,et(ar(c)));r=ur(T.body,lr,L,ge)}}f.isString(p)||(p=p?"include":"omit");const m="credentials"in Request.prototype;g=new Request(t,{...h,signal:_,method:n.toUpperCase(),headers:l.normalize().toJSON(),body:r,duplex:"half",credentials:m?p:void 0});let w=await fetch(g);const E=Wt&&(u==="stream"||u==="response");if(Wt&&(a||E&&b)){const T={};["status","statusText","headers"].forEach(qe=>{T[qe]=w[qe]});const N=f.toFiniteNumber(w.headers.get("content-length")),[L,ge]=a&&sr(N,et(ar(a),!0))||[];w=new Response(ur(w.body,lr,L,()=>{ge&&ge(),b&&b()}),T)}u=u||"text";let x=await tt[f.findKey(tt,u)||"text"](w,e);return!E&&b&&b(),await new Promise((T,N)=>{ci(T,N,{data:x,headers:k.from(w.headers),status:w.status,statusText:w.statusText,config:e,request:g})})}catch(m){throw b&&b(),m&&m.name==="TypeError"&&/fetch/i.test(m.message)?Object.assign(new y("Network Error",y.ERR_NETWORK,e,g),{cause:m.cause||m}):y.from(m,m&&m.code,e,g)}}),Jt={http:Zs,xhr:Ca,fetch:$a};f.forEach(Jt,(e,t)=>{if(e){try{Object.defineProperty(e,"name",{value:t})}catch{}Object.defineProperty(e,"adapterName",{value:t})}});const fr=e=>`- ${e}`,Fa=e=>f.isFunction(e)||e===null||e===!1,pi={getAdapter:e=>{e=f.isArray(e)?e:[e];const{length:t}=e;let n,r;const i={};for(let o=0;o<t;o++){n=e[o];let s;if(r=n,!Fa(n)&&(r=Jt[(s=String(n)).toLowerCase()],r===void 0))throw new y(`Unknown adapter '${s}'`);if(r)break;i[s||"#"+o]=r}if(!r){const o=Object.entries(i).map(([a,c])=>`adapter ${a} `+(c===!1?"is not supported by the environment":"is not available in the build"));let s=t?o.length>1?`since :
`+o.map(fr).join(`
`):" "+fr(o[0]):"as no adapter specified";throw new y("There is no suitable adapter to dispatch the request "+s,"ERR_NOT_SUPPORT")}return r},adapters:Jt};function Ct(e){if(e.cancelToken&&e.cancelToken.throwIfRequested(),e.signal&&e.signal.aborted)throw new ye(null,e)}function dr(e){return Ct(e),e.headers=k.from(e.headers),e.data=Ot.call(e,e.transformRequest),["post","put","patch"].indexOf(e.method)!==-1&&e.headers.setContentType("application/x-www-form-urlencoded",!1),pi.getAdapter(e.adapter||Le.adapter)(e).then(function(r){return Ct(e),r.data=Ot.call(e,e.transformResponse,r),r.headers=k.from(r.headers),r},function(r){return ai(r)||(Ct(e),r&&r.response&&(r.response.data=Ot.call(e,e.transformResponse,r.response),r.response.headers=k.from(r.response.headers))),Promise.reject(r)})}const hi="1.8.2",ht={};["object","boolean","number","function","string","symbol"].forEach((e,t)=>{ht[e]=function(r){return typeof r===e||"a"+(t<1?"n ":" ")+e}});const pr={};ht.transitional=function(t,n,r){function i(o,s){return"[Axios v"+hi+"] Transitional option '"+o+"'"+s+(r?". "+r:"")}return(o,s,a)=>{if(t===!1)throw new y(i(s," has been removed"+(n?" in "+n:"")),y.ERR_DEPRECATED);return n&&!pr[s]&&(pr[s]=!0,console.warn(i(s," has been deprecated since v"+n+" and will be removed in the near future"))),t?t(o,s,a):!0}};ht.spelling=function(t){return(n,r)=>(console.warn(`${r} is likely a misspelling of ${t}`),!0)};function La(e,t,n){if(typeof e!="object")throw new y("options must be an object",y.ERR_BAD_OPTION_VALUE);const r=Object.keys(e);let i=r.length;for(;i-- >0;){const o=r[i],s=t[o];if(s){const a=e[o],c=a===void 0||s(a,o,e);if(c!==!0)throw new y("option "+o+" must be "+c,y.ERR_BAD_OPTION_VALUE);continue}if(n!==!0)throw new y("Unknown option "+o,y.ERR_BAD_OPTION)}}const Ye={assertOptions:La,validators:ht},j=Ye.validators;let ie=class{constructor(t){this.defaults=t,this.interceptors={request:new ir,response:new ir}}async request(t,n){try{return await this._request(t,n)}catch(r){if(r instanceof Error){let i={};Error.captureStackTrace?Error.captureStackTrace(i):i=new Error;const o=i.stack?i.stack.replace(/^.+\n/,""):"";try{r.stack?o&&!String(r.stack).endsWith(o.replace(/^.+\n.+\n/,""))&&(r.stack+=`
`+o):r.stack=o}catch{}}throw r}}_request(t,n){typeof t=="string"?(n=n||{},n.url=t):n=t||{},n=ue(this.defaults,n);const{transitional:r,paramsSerializer:i,headers:o}=n;r!==void 0&&Ye.assertOptions(r,{silentJSONParsing:j.transitional(j.boolean),forcedJSONParsing:j.transitional(j.boolean),clarifyTimeoutError:j.transitional(j.boolean)},!1),i!=null&&(f.isFunction(i)?n.paramsSerializer={serialize:i}:Ye.assertOptions(i,{encode:j.function,serialize:j.function},!0)),n.allowAbsoluteUrls!==void 0||(this.defaults.allowAbsoluteUrls!==void 0?n.allowAbsoluteUrls=this.defaults.allowAbsoluteUrls:n.allowAbsoluteUrls=!0),Ye.assertOptions(n,{baseUrl:j.spelling("baseURL"),withXsrfToken:j.spelling("withXSRFToken")},!0),n.method=(n.method||this.defaults.method||"get").toLowerCase();let s=o&&f.merge(o.common,o[n.method]);o&&f.forEach(["delete","get","head","post","put","patch","common"],g=>{delete o[g]}),n.headers=k.concat(s,o);const a=[];let c=!0;this.interceptors.request.forEach(function(b){typeof b.runWhen=="function"&&b.runWhen(n)===!1||(c=c&&b.synchronous,a.unshift(b.fulfilled,b.rejected))});const u=[];this.interceptors.response.forEach(function(b){u.push(b.fulfilled,b.rejected)});let l,p=0,h;if(!c){const g=[dr.bind(this),void 0];for(g.unshift.apply(g,a),g.push.apply(g,u),h=g.length,l=Promise.resolve(n);p<h;)l=l.then(g[p++],g[p++]);return l}h=a.length;let _=n;for(p=0;p<h;){const g=a[p++],b=a[p++];try{_=g(_)}catch(d){b.call(this,d);break}}try{l=dr.call(this,_)}catch(g){return Promise.reject(g)}for(p=0,h=u.length;p<h;)l=l.then(u[p++],u[p++]);return l}getUri(t){t=ue(this.defaults,t);const n=ui(t.baseURL,t.url,t.allowAbsoluteUrls);return ii(n,t.params,t.paramsSerializer)}};f.forEach(["delete","get","head","options"],function(t){ie.prototype[t]=function(n,r){return this.request(ue(r||{},{method:t,url:n,data:(r||{}).data}))}});f.forEach(["post","put","patch"],function(t){function n(r){return function(o,s,a){return this.request(ue(a||{},{method:t,headers:r?{"Content-Type":"multipart/form-data"}:{},url:o,data:s}))}}ie.prototype[t]=n(),ie.prototype[t+"Form"]=n(!0)});let ja=class gi{constructor(t){if(typeof t!="function")throw new TypeError("executor must be a function.");let n;this.promise=new Promise(function(o){n=o});const r=this;this.promise.then(i=>{if(!r._listeners)return;let o=r._listeners.length;for(;o-- >0;)r._listeners[o](i);r._listeners=null}),this.promise.then=i=>{let o;const s=new Promise(a=>{r.subscribe(a),o=a}).then(i);return s.cancel=function(){r.unsubscribe(o)},s},t(function(o,s,a){r.reason||(r.reason=new ye(o,s,a),n(r.reason))})}throwIfRequested(){if(this.reason)throw this.reason}subscribe(t){if(this.reason){t(this.reason);return}this._listeners?this._listeners.push(t):this._listeners=[t]}unsubscribe(t){if(!this._listeners)return;const n=this._listeners.indexOf(t);n!==-1&&this._listeners.splice(n,1)}toAbortSignal(){const t=new AbortController,n=r=>{t.abort(r)};return this.subscribe(n),t.signal.unsubscribe=()=>this.unsubscribe(n),t.signal}static source(){let t;return{token:new gi(function(i){t=i}),cancel:t}}};function Ha(e){return function(n){return e.apply(null,n)}}function Ua(e){return f.isObject(e)&&e.isAxiosError===!0}const Gt={Continue:100,SwitchingProtocols:101,Processing:102,EarlyHints:103,Ok:200,Created:201,Accepted:202,NonAuthoritativeInformation:203,NoContent:204,ResetContent:205,PartialContent:206,MultiStatus:207,AlreadyReported:208,ImUsed:226,MultipleChoices:300,MovedPermanently:301,Found:302,SeeOther:303,NotModified:304,UseProxy:305,Unused:306,TemporaryRedirect:307,PermanentRedirect:308,BadRequest:400,Unauthorized:401,PaymentRequired:402,Forbidden:403,NotFound:404,MethodNotAllowed:405,NotAcceptable:406,ProxyAuthenticationRequired:407,RequestTimeout:408,Conflict:409,Gone:410,LengthRequired:411,PreconditionFailed:412,PayloadTooLarge:413,UriTooLong:414,UnsupportedMediaType:415,RangeNotSatisfiable:416,ExpectationFailed:417,ImATeapot:418,MisdirectedRequest:421,UnprocessableEntity:422,Locked:423,FailedDependency:424,TooEarly:425,UpgradeRequired:426,PreconditionRequired:428,TooManyRequests:429,RequestHeaderFieldsTooLarge:431,UnavailableForLegalReasons:451,InternalServerError:500,NotImplemented:501,BadGateway:502,ServiceUnavailable:503,GatewayTimeout:504,HttpVersionNotSupported:505,VariantAlsoNegotiates:506,InsufficientStorage:507,LoopDetected:508,NotExtended:510,NetworkAuthenticationRequired:511};Object.entries(Gt).forEach(([e,t])=>{Gt[t]=e});function mi(e){const t=new ie(e),n=Wr(ie.prototype.request,t);return f.extend(n,ie.prototype,t,{allOwnKeys:!0}),f.extend(n,t,null,{allOwnKeys:!0}),n.create=function(i){return mi(ue(e,i))},n}const O=mi(Le);O.Axios=ie;O.CanceledError=ye;O.CancelToken=ja;O.isCancel=ai;O.VERSION=hi;O.toFormData=dt;O.AxiosError=y;O.Cancel=O.CanceledError;O.all=function(t){return Promise.all(t)};O.spread=Ha;O.isAxiosError=Ua;O.mergeConfig=ue;O.AxiosHeaders=k;O.formToJSON=e=>si(f.isHTMLForm(e)?new FormData(e):e);O.getAdapter=pi.getAdapter;O.HttpStatusCode=Gt;O.default=O;const{Axios:ip,AxiosError:op,CanceledError:sp,isCancel:ap,CancelToken:cp,VERSION:up,all:lp,Cancel:fp,isAxiosError:dp,spread:pp,toFormData:hp,AxiosHeaders:gp,HttpStatusCode:mp,formToJSON:bp,getAdapter:_p,mergeConfig:yp}=O;window.axios=O;window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";ps();var Xt=!1,Yt=!1,oe=[],Zt=-1;function qa(e){Ka(e)}function Ka(e){oe.includes(e)||oe.push(e),za()}function Va(e){let t=oe.indexOf(e);t!==-1&&t>Zt&&oe.splice(t,1)}function za(){!Yt&&!Xt&&(Xt=!0,queueMicrotask(Wa))}function Wa(){Xt=!1,Yt=!0;for(let e=0;e<oe.length;e++)oe[e](),Zt=e;oe.length=0,Zt=-1,Yt=!1}var we,he,Ee,bi,Qt=!0;function Ja(e){Qt=!1,e(),Qt=!0}function Ga(e){we=e.reactive,Ee=e.release,he=t=>e.effect(t,{scheduler:n=>{Qt?qa(n):n()}}),bi=e.raw}function hr(e){he=e}function Xa(e){let t=()=>{};return[r=>{let i=he(r);return e._x_effects||(e._x_effects=new Set,e._x_runEffects=()=>{e._x_effects.forEach(o=>o())}),e._x_effects.add(i),t=()=>{i!==void 0&&(e._x_effects.delete(i),Ee(i))},i},()=>{t()}]}function _i(e,t){let n=!0,r,i=he(()=>{let o=e();JSON.stringify(o),n?r=o:queueMicrotask(()=>{t(o,r),r=o}),n=!1});return()=>Ee(i)}var yi=[],wi=[],Ei=[];function Ya(e){Ei.push(e)}function An(e,t){typeof t=="function"?(e._x_cleanups||(e._x_cleanups=[]),e._x_cleanups.push(t)):(t=e,wi.push(t))}function Si(e){yi.push(e)}function vi(e,t,n){e._x_attributeCleanups||(e._x_attributeCleanups={}),e._x_attributeCleanups[t]||(e._x_attributeCleanups[t]=[]),e._x_attributeCleanups[t].push(n)}function Ai(e,t){e._x_attributeCleanups&&Object.entries(e._x_attributeCleanups).forEach(([n,r])=>{(t===void 0||t.includes(n))&&(r.forEach(i=>i()),delete e._x_attributeCleanups[n])})}function Za(e){var t,n;for((t=e._x_effects)==null||t.forEach(Va);(n=e._x_cleanups)!=null&&n.length;)e._x_cleanups.pop()()}var xn=new MutationObserver(In),Tn=!1;function On(){xn.observe(document,{subtree:!0,childList:!0,attributes:!0,attributeOldValue:!0}),Tn=!0}function xi(){Qa(),xn.disconnect(),Tn=!1}var Oe=[];function Qa(){let e=xn.takeRecords();Oe.push(()=>e.length>0&&In(e));let t=Oe.length;queueMicrotask(()=>{if(Oe.length===t)for(;Oe.length>0;)Oe.shift()()})}function A(e){if(!Tn)return e();xi();let t=e();return On(),t}var Cn=!1,nt=[];function ec(){Cn=!0}function tc(){Cn=!1,In(nt),nt=[]}function In(e){if(Cn){nt=nt.concat(e);return}let t=[],n=new Set,r=new Map,i=new Map;for(let o=0;o<e.length;o++)if(!e[o].target._x_ignoreMutationObserver&&(e[o].type==="childList"&&(e[o].removedNodes.forEach(s=>{s.nodeType===1&&s._x_marker&&n.add(s)}),e[o].addedNodes.forEach(s=>{if(s.nodeType===1){if(n.has(s)){n.delete(s);return}s._x_marker||t.push(s)}})),e[o].type==="attributes")){let s=e[o].target,a=e[o].attributeName,c=e[o].oldValue,u=()=>{r.has(s)||r.set(s,[]),r.get(s).push({name:a,value:s.getAttribute(a)})},l=()=>{i.has(s)||i.set(s,[]),i.get(s).push(a)};s.hasAttribute(a)&&c===null?u():s.hasAttribute(a)?(l(),u()):l()}i.forEach((o,s)=>{Ai(s,o)}),r.forEach((o,s)=>{yi.forEach(a=>a(s,o))});for(let o of n)t.some(s=>s.contains(o))||wi.forEach(s=>s(o));for(let o of t)o.isConnected&&Ei.forEach(s=>s(o));t=null,n=null,r=null,i=null}function Ti(e){return He(me(e))}function je(e,t,n){return e._x_dataStack=[t,...me(n||e)],()=>{e._x_dataStack=e._x_dataStack.filter(r=>r!==t)}}function me(e){return e._x_dataStack?e._x_dataStack:typeof ShadowRoot=="function"&&e instanceof ShadowRoot?me(e.host):e.parentNode?me(e.parentNode):[]}function He(e){return new Proxy({objects:e},nc)}var nc={ownKeys({objects:e}){return Array.from(new Set(e.flatMap(t=>Object.keys(t))))},has({objects:e},t){return t==Symbol.unscopables?!1:e.some(n=>Object.prototype.hasOwnProperty.call(n,t)||Reflect.has(n,t))},get({objects:e},t,n){return t=="toJSON"?rc:Reflect.get(e.find(r=>Reflect.has(r,t))||{},t,n)},set({objects:e},t,n,r){const i=e.find(s=>Object.prototype.hasOwnProperty.call(s,t))||e[e.length-1],o=Object.getOwnPropertyDescriptor(i,t);return o!=null&&o.set&&(o!=null&&o.get)?o.set.call(r,n)||!0:Reflect.set(i,t,n)}};function rc(){return Reflect.ownKeys(this).reduce((t,n)=>(t[n]=Reflect.get(this,n),t),{})}function Oi(e){let t=r=>typeof r=="object"&&!Array.isArray(r)&&r!==null,n=(r,i="")=>{Object.entries(Object.getOwnPropertyDescriptors(r)).forEach(([o,{value:s,enumerable:a}])=>{if(a===!1||s===void 0||typeof s=="object"&&s!==null&&s.__v_skip)return;let c=i===""?o:`${i}.${o}`;typeof s=="object"&&s!==null&&s._x_interceptor?r[o]=s.initialize(e,c,o):t(s)&&s!==r&&!(s instanceof Element)&&n(s,c)})};return n(e)}function Ci(e,t=()=>{}){let n={initialValue:void 0,_x_interceptor:!0,initialize(r,i,o){return e(this.initialValue,()=>ic(r,i),s=>en(r,i,s),i,o)}};return t(n),r=>{if(typeof r=="object"&&r!==null&&r._x_interceptor){let i=n.initialize.bind(n);n.initialize=(o,s,a)=>{let c=r.initialize(o,s,a);return n.initialValue=c,i(o,s,a)}}else n.initialValue=r;return n}}function ic(e,t){return t.split(".").reduce((n,r)=>n[r],e)}function en(e,t,n){if(typeof t=="string"&&(t=t.split(".")),t.length===1)e[t[0]]=n;else{if(t.length===0)throw error;return e[t[0]]||(e[t[0]]={}),en(e[t[0]],t.slice(1),n)}}var Ii={};function F(e,t){Ii[e]=t}function tn(e,t){let n=oc(t);return Object.entries(Ii).forEach(([r,i])=>{Object.defineProperty(e,`$${r}`,{get(){return i(t,n)},enumerable:!1})}),e}function oc(e){let[t,n]=Mi(e),r={interceptor:Ci,...t};return An(e,n),r}function sc(e,t,n,...r){try{return n(...r)}catch(i){Pe(i,e,t)}}function Pe(e,t,n=void 0){e=Object.assign(e??{message:"No error message given."},{el:t,expression:n}),console.warn(`Alpine Expression Error: ${e.message}

${n?'Expression: "'+n+`"

`:""}`,t),setTimeout(()=>{throw e},0)}var Ze=!0;function Ri(e){let t=Ze;Ze=!1;let n=e();return Ze=t,n}function se(e,t,n={}){let r;return D(e,t)(i=>r=i,n),r}function D(...e){return Di(...e)}var Di=Ni;function ac(e){Di=e}function Ni(e,t){let n={};tn(n,e);let r=[n,...me(e)],i=typeof t=="function"?cc(r,t):lc(r,t,e);return sc.bind(null,e,t,i)}function cc(e,t){return(n=()=>{},{scope:r={},params:i=[]}={})=>{let o=t.apply(He([r,...e]),i);rt(n,o)}}var It={};function uc(e,t){if(It[e])return It[e];let n=Object.getPrototypeOf(async function(){}).constructor,r=/^[\n\s]*if.*\(.*\)/.test(e.trim())||/^(let|const)\s/.test(e.trim())?`(async()=>{ ${e} })()`:e,o=(()=>{try{let s=new n(["__self","scope"],`with (scope) { __self.result = ${r} }; __self.finished = true; return __self.result;`);return Object.defineProperty(s,"name",{value:`[Alpine] ${e}`}),s}catch(s){return Pe(s,t,e),Promise.resolve()}})();return It[e]=o,o}function lc(e,t,n){let r=uc(t,n);return(i=()=>{},{scope:o={},params:s=[]}={})=>{r.result=void 0,r.finished=!1;let a=He([o,...e]);if(typeof r=="function"){let c=r(r,a).catch(u=>Pe(u,n,t));r.finished?(rt(i,r.result,a,s,n),r.result=void 0):c.then(u=>{rt(i,u,a,s,n)}).catch(u=>Pe(u,n,t)).finally(()=>r.result=void 0)}}}function rt(e,t,n,r,i){if(Ze&&typeof t=="function"){let o=t.apply(n,r);o instanceof Promise?o.then(s=>rt(e,s,n,r)).catch(s=>Pe(s,i,t)):e(o)}else typeof t=="object"&&t instanceof Promise?t.then(o=>e(o)):e(t)}var Rn="x-";function Se(e=""){return Rn+e}function fc(e){Rn=e}var it={};function C(e,t){return it[e]=t,{before(n){if(!it[n]){console.warn(String.raw`Cannot find directive \`${n}\`. \`${e}\` will use the default order of execution`);return}const r=ne.indexOf(n);ne.splice(r>=0?r:ne.indexOf("DEFAULT"),0,e)}}}function dc(e){return Object.keys(it).includes(e)}function Dn(e,t,n){if(t=Array.from(t),e._x_virtualDirectives){let o=Object.entries(e._x_virtualDirectives).map(([a,c])=>({name:a,value:c})),s=ki(o);o=o.map(a=>s.find(c=>c.name===a.name)?{name:`x-bind:${a.name}`,value:`"${a.value}"`}:a),t=t.concat(o)}let r={};return t.map(Fi((o,s)=>r[o]=s)).filter(ji).map(gc(r,n)).sort(mc).map(o=>hc(e,o))}function ki(e){return Array.from(e).map(Fi()).filter(t=>!ji(t))}var nn=!1,Re=new Map,Pi=Symbol();function pc(e){nn=!0;let t=Symbol();Pi=t,Re.set(t,[]);let n=()=>{for(;Re.get(t).length;)Re.get(t).shift()();Re.delete(t)},r=()=>{nn=!1,n()};e(n),r()}function Mi(e){let t=[],n=a=>t.push(a),[r,i]=Xa(e);return t.push(i),[{Alpine:Ue,effect:r,cleanup:n,evaluateLater:D.bind(D,e),evaluate:se.bind(se,e)},()=>t.forEach(a=>a())]}function hc(e,t){let n=()=>{},r=it[t.type]||n,[i,o]=Mi(e);vi(e,t.original,o);let s=()=>{e._x_ignore||e._x_ignoreSelf||(r.inline&&r.inline(e,t,i),r=r.bind(r,e,t,i),nn?Re.get(Pi).push(r):r())};return s.runCleanups=o,s}var Bi=(e,t)=>({name:n,value:r})=>(n.startsWith(e)&&(n=n.replace(e,t)),{name:n,value:r}),$i=e=>e;function Fi(e=()=>{}){return({name:t,value:n})=>{let{name:r,value:i}=Li.reduce((o,s)=>s(o),{name:t,value:n});return r!==t&&e(r,t),{name:r,value:i}}}var Li=[];function Nn(e){Li.push(e)}function ji({name:e}){return Hi().test(e)}var Hi=()=>new RegExp(`^${Rn}([^:^.]+)\\b`);function gc(e,t){return({name:n,value:r})=>{let i=n.match(Hi()),o=n.match(/:([a-zA-Z0-9\-_:]+)/),s=n.match(/\.[^.\]]+(?=[^\]]*$)/g)||[],a=t||e[n]||n;return{type:i?i[1]:null,value:o?o[1]:null,modifiers:s.map(c=>c.replace(".","")),expression:r,original:a}}}var rn="DEFAULT",ne=["ignore","ref","data","id","anchor","bind","init","for","model","modelable","transition","show","if",rn,"teleport"];function mc(e,t){let n=ne.indexOf(e.type)===-1?rn:e.type,r=ne.indexOf(t.type)===-1?rn:t.type;return ne.indexOf(n)-ne.indexOf(r)}function De(e,t,n={}){e.dispatchEvent(new CustomEvent(t,{detail:n,bubbles:!0,composed:!0,cancelable:!0}))}function le(e,t){if(typeof ShadowRoot=="function"&&e instanceof ShadowRoot){Array.from(e.children).forEach(i=>le(i,t));return}let n=!1;if(t(e,()=>n=!0),n)return;let r=e.firstElementChild;for(;r;)le(r,t),r=r.nextElementSibling}function M(e,...t){console.warn(`Alpine Warning: ${e}`,...t)}var gr=!1;function bc(){gr&&M("Alpine has already been initialized on this page. Calling Alpine.start() more than once can cause problems."),gr=!0,document.body||M("Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?"),De(document,"alpine:init"),De(document,"alpine:initializing"),On(),Ya(t=>K(t,le)),An(t=>Ae(t)),Si((t,n)=>{Dn(t,n).forEach(r=>r())});let e=t=>!gt(t.parentElement,!0);Array.from(document.querySelectorAll(Ki().join(","))).filter(e).forEach(t=>{K(t)}),De(document,"alpine:initialized"),setTimeout(()=>{Ec()})}var kn=[],Ui=[];function qi(){return kn.map(e=>e())}function Ki(){return kn.concat(Ui).map(e=>e())}function Vi(e){kn.push(e)}function zi(e){Ui.push(e)}function gt(e,t=!1){return ve(e,n=>{if((t?Ki():qi()).some(i=>n.matches(i)))return!0})}function ve(e,t){if(e){if(t(e))return e;if(e._x_teleportBack&&(e=e._x_teleportBack),!!e.parentElement)return ve(e.parentElement,t)}}function _c(e){return qi().some(t=>e.matches(t))}var Wi=[];function yc(e){Wi.push(e)}var wc=1;function K(e,t=le,n=()=>{}){ve(e,r=>r._x_ignore)||pc(()=>{t(e,(r,i)=>{r._x_marker||(n(r,i),Wi.forEach(o=>o(r,i)),Dn(r,r.attributes).forEach(o=>o()),r._x_ignore||(r._x_marker=wc++),r._x_ignore&&i())})})}function Ae(e,t=le){t(e,n=>{Za(n),Ai(n),delete n._x_marker})}function Ec(){[["ui","dialog",["[x-dialog], [x-popover]"]],["anchor","anchor",["[x-anchor]"]],["sort","sort",["[x-sort]"]]].forEach(([t,n,r])=>{dc(n)||r.some(i=>{if(document.querySelector(i))return M(`found "${i}", but missing ${t} plugin`),!0})})}var on=[],Pn=!1;function Mn(e=()=>{}){return queueMicrotask(()=>{Pn||setTimeout(()=>{sn()})}),new Promise(t=>{on.push(()=>{e(),t()})})}function sn(){for(Pn=!1;on.length;)on.shift()()}function Sc(){Pn=!0}function Bn(e,t){return Array.isArray(t)?mr(e,t.join(" ")):typeof t=="object"&&t!==null?vc(e,t):typeof t=="function"?Bn(e,t()):mr(e,t)}function mr(e,t){let n=i=>i.split(" ").filter(o=>!e.classList.contains(o)).filter(Boolean),r=i=>(e.classList.add(...i),()=>{e.classList.remove(...i)});return t=t===!0?t="":t||"",r(n(t))}function vc(e,t){let n=a=>a.split(" ").filter(Boolean),r=Object.entries(t).flatMap(([a,c])=>c?n(a):!1).filter(Boolean),i=Object.entries(t).flatMap(([a,c])=>c?!1:n(a)).filter(Boolean),o=[],s=[];return i.forEach(a=>{e.classList.contains(a)&&(e.classList.remove(a),s.push(a))}),r.forEach(a=>{e.classList.contains(a)||(e.classList.add(a),o.push(a))}),()=>{s.forEach(a=>e.classList.add(a)),o.forEach(a=>e.classList.remove(a))}}function mt(e,t){return typeof t=="object"&&t!==null?Ac(e,t):xc(e,t)}function Ac(e,t){let n={};return Object.entries(t).forEach(([r,i])=>{n[r]=e.style[r],r.startsWith("--")||(r=Tc(r)),e.style.setProperty(r,i)}),setTimeout(()=>{e.style.length===0&&e.removeAttribute("style")}),()=>{mt(e,n)}}function xc(e,t){let n=e.getAttribute("style",t);return e.setAttribute("style",t),()=>{e.setAttribute("style",n||"")}}function Tc(e){return e.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase()}function an(e,t=()=>{}){let n=!1;return function(){n?t.apply(this,arguments):(n=!0,e.apply(this,arguments))}}C("transition",(e,{value:t,modifiers:n,expression:r},{evaluate:i})=>{typeof r=="function"&&(r=i(r)),r!==!1&&(!r||typeof r=="boolean"?Cc(e,n,t):Oc(e,r,t))});function Oc(e,t,n){Ji(e,Bn,""),{enter:i=>{e._x_transition.enter.during=i},"enter-start":i=>{e._x_transition.enter.start=i},"enter-end":i=>{e._x_transition.enter.end=i},leave:i=>{e._x_transition.leave.during=i},"leave-start":i=>{e._x_transition.leave.start=i},"leave-end":i=>{e._x_transition.leave.end=i}}[n](t)}function Cc(e,t,n){Ji(e,mt);let r=!t.includes("in")&&!t.includes("out")&&!n,i=r||t.includes("in")||["enter"].includes(n),o=r||t.includes("out")||["leave"].includes(n);t.includes("in")&&!r&&(t=t.filter((m,w)=>w<t.indexOf("out"))),t.includes("out")&&!r&&(t=t.filter((m,w)=>w>t.indexOf("out")));let s=!t.includes("opacity")&&!t.includes("scale"),a=s||t.includes("opacity"),c=s||t.includes("scale"),u=a?0:1,l=c?Ce(t,"scale",95)/100:1,p=Ce(t,"delay",0)/1e3,h=Ce(t,"origin","center"),_="opacity, transform",g=Ce(t,"duration",150)/1e3,b=Ce(t,"duration",75)/1e3,d="cubic-bezier(0.4, 0.0, 0.2, 1)";i&&(e._x_transition.enter.during={transformOrigin:h,transitionDelay:`${p}s`,transitionProperty:_,transitionDuration:`${g}s`,transitionTimingFunction:d},e._x_transition.enter.start={opacity:u,transform:`scale(${l})`},e._x_transition.enter.end={opacity:1,transform:"scale(1)"}),o&&(e._x_transition.leave.during={transformOrigin:h,transitionDelay:`${p}s`,transitionProperty:_,transitionDuration:`${b}s`,transitionTimingFunction:d},e._x_transition.leave.start={opacity:1,transform:"scale(1)"},e._x_transition.leave.end={opacity:u,transform:`scale(${l})`})}function Ji(e,t,n={}){e._x_transition||(e._x_transition={enter:{during:n,start:n,end:n},leave:{during:n,start:n,end:n},in(r=()=>{},i=()=>{}){cn(e,t,{during:this.enter.during,start:this.enter.start,end:this.enter.end},r,i)},out(r=()=>{},i=()=>{}){cn(e,t,{during:this.leave.during,start:this.leave.start,end:this.leave.end},r,i)}})}window.Element.prototype._x_toggleAndCascadeWithTransitions=function(e,t,n,r){const i=document.visibilityState==="visible"?requestAnimationFrame:setTimeout;let o=()=>i(n);if(t){e._x_transition&&(e._x_transition.enter||e._x_transition.leave)?e._x_transition.enter&&(Object.entries(e._x_transition.enter.during).length||Object.entries(e._x_transition.enter.start).length||Object.entries(e._x_transition.enter.end).length)?e._x_transition.in(n):o():e._x_transition?e._x_transition.in(n):o();return}e._x_hidePromise=e._x_transition?new Promise((s,a)=>{e._x_transition.out(()=>{},()=>s(r)),e._x_transitioning&&e._x_transitioning.beforeCancel(()=>a({isFromCancelledTransition:!0}))}):Promise.resolve(r),queueMicrotask(()=>{let s=Gi(e);s?(s._x_hideChildren||(s._x_hideChildren=[]),s._x_hideChildren.push(e)):i(()=>{let a=c=>{let u=Promise.all([c._x_hidePromise,...(c._x_hideChildren||[]).map(a)]).then(([l])=>l==null?void 0:l());return delete c._x_hidePromise,delete c._x_hideChildren,u};a(e).catch(c=>{if(!c.isFromCancelledTransition)throw c})})})};function Gi(e){let t=e.parentNode;if(t)return t._x_hidePromise?t:Gi(t)}function cn(e,t,{during:n,start:r,end:i}={},o=()=>{},s=()=>{}){if(e._x_transitioning&&e._x_transitioning.cancel(),Object.keys(n).length===0&&Object.keys(r).length===0&&Object.keys(i).length===0){o(),s();return}let a,c,u;Ic(e,{start(){a=t(e,r)},during(){c=t(e,n)},before:o,end(){a(),u=t(e,i)},after:s,cleanup(){c(),u()}})}function Ic(e,t){let n,r,i,o=an(()=>{A(()=>{n=!0,r||t.before(),i||(t.end(),sn()),t.after(),e.isConnected&&t.cleanup(),delete e._x_transitioning})});e._x_transitioning={beforeCancels:[],beforeCancel(s){this.beforeCancels.push(s)},cancel:an(function(){for(;this.beforeCancels.length;)this.beforeCancels.shift()();o()}),finish:o},A(()=>{t.start(),t.during()}),Sc(),requestAnimationFrame(()=>{if(n)return;let s=Number(getComputedStyle(e).transitionDuration.replace(/,.*/,"").replace("s",""))*1e3,a=Number(getComputedStyle(e).transitionDelay.replace(/,.*/,"").replace("s",""))*1e3;s===0&&(s=Number(getComputedStyle(e).animationDuration.replace("s",""))*1e3),A(()=>{t.before()}),r=!0,requestAnimationFrame(()=>{n||(A(()=>{t.end()}),sn(),setTimeout(e._x_transitioning.finish,s+a),i=!0)})})}function Ce(e,t,n){if(e.indexOf(t)===-1)return n;const r=e[e.indexOf(t)+1];if(!r||t==="scale"&&isNaN(r))return n;if(t==="duration"||t==="delay"){let i=r.match(/([0-9]+)ms/);if(i)return i[1]}return t==="origin"&&["top","right","left","center","bottom"].includes(e[e.indexOf(t)+2])?[r,e[e.indexOf(t)+2]].join(" "):r}var G=!1;function Z(e,t=()=>{}){return(...n)=>G?t(...n):e(...n)}function Rc(e){return(...t)=>G&&e(...t)}var Xi=[];function bt(e){Xi.push(e)}function Dc(e,t){Xi.forEach(n=>n(e,t)),G=!0,Yi(()=>{K(t,(n,r)=>{r(n,()=>{})})}),G=!1}var un=!1;function Nc(e,t){t._x_dataStack||(t._x_dataStack=e._x_dataStack),G=!0,un=!0,Yi(()=>{kc(t)}),G=!1,un=!1}function kc(e){let t=!1;K(e,(r,i)=>{le(r,(o,s)=>{if(t&&_c(o))return s();t=!0,i(o,s)})})}function Yi(e){let t=he;hr((n,r)=>{let i=t(n);return Ee(i),()=>{}}),e(),hr(t)}function Zi(e,t,n,r=[]){switch(e._x_bindings||(e._x_bindings=we({})),e._x_bindings[t]=n,t=r.includes("camel")?Hc(t):t,t){case"value":Pc(e,n);break;case"style":Bc(e,n);break;case"class":Mc(e,n);break;case"selected":case"checked":$c(e,t,n);break;default:Qi(e,t,n);break}}function Pc(e,t){if(no(e))e.attributes.value===void 0&&(e.value=t),window.fromModel&&(typeof t=="boolean"?e.checked=Qe(e.value)===t:e.checked=br(e.value,t));else if($n(e))Number.isInteger(t)?e.value=t:!Array.isArray(t)&&typeof t!="boolean"&&![null,void 0].includes(t)?e.value=String(t):Array.isArray(t)?e.checked=t.some(n=>br(n,e.value)):e.checked=!!t;else if(e.tagName==="SELECT")jc(e,t);else{if(e.value===t)return;e.value=t===void 0?"":t}}function Mc(e,t){e._x_undoAddedClasses&&e._x_undoAddedClasses(),e._x_undoAddedClasses=Bn(e,t)}function Bc(e,t){e._x_undoAddedStyles&&e._x_undoAddedStyles(),e._x_undoAddedStyles=mt(e,t)}function $c(e,t,n){Qi(e,t,n),Lc(e,t,n)}function Qi(e,t,n){[null,void 0,!1].includes(n)&&qc(t)?e.removeAttribute(t):(eo(t)&&(n=t),Fc(e,t,n))}function Fc(e,t,n){e.getAttribute(t)!=n&&e.setAttribute(t,n)}function Lc(e,t,n){e[t]!==n&&(e[t]=n)}function jc(e,t){const n=[].concat(t).map(r=>r+"");Array.from(e.options).forEach(r=>{r.selected=n.includes(r.value)})}function Hc(e){return e.toLowerCase().replace(/-(\w)/g,(t,n)=>n.toUpperCase())}function br(e,t){return e==t}function Qe(e){return[1,"1","true","on","yes",!0].includes(e)?!0:[0,"0","false","off","no",!1].includes(e)?!1:e?!!e:null}var Uc=new Set(["allowfullscreen","async","autofocus","autoplay","checked","controls","default","defer","disabled","formnovalidate","inert","ismap","itemscope","loop","multiple","muted","nomodule","novalidate","open","playsinline","readonly","required","reversed","selected","shadowrootclonable","shadowrootdelegatesfocus","shadowrootserializable"]);function eo(e){return Uc.has(e)}function qc(e){return!["aria-pressed","aria-checked","aria-expanded","aria-selected"].includes(e)}function Kc(e,t,n){return e._x_bindings&&e._x_bindings[t]!==void 0?e._x_bindings[t]:to(e,t,n)}function Vc(e,t,n,r=!0){if(e._x_bindings&&e._x_bindings[t]!==void 0)return e._x_bindings[t];if(e._x_inlineBindings&&e._x_inlineBindings[t]!==void 0){let i=e._x_inlineBindings[t];return i.extract=r,Ri(()=>se(e,i.expression))}return to(e,t,n)}function to(e,t,n){let r=e.getAttribute(t);return r===null?typeof n=="function"?n():n:r===""?!0:eo(t)?!![t,"true"].includes(r):r}function $n(e){return e.type==="checkbox"||e.localName==="ui-checkbox"||e.localName==="ui-switch"}function no(e){return e.type==="radio"||e.localName==="ui-radio"}function ro(e,t){var n;return function(){var r=this,i=arguments,o=function(){n=null,e.apply(r,i)};clearTimeout(n),n=setTimeout(o,t)}}function io(e,t){let n;return function(){let r=this,i=arguments;n||(e.apply(r,i),n=!0,setTimeout(()=>n=!1,t))}}function oo({get:e,set:t},{get:n,set:r}){let i=!0,o,s=he(()=>{let a=e(),c=n();if(i)r(Rt(a)),i=!1;else{let u=JSON.stringify(a),l=JSON.stringify(c);u!==o?r(Rt(a)):u!==l&&t(Rt(c))}o=JSON.stringify(e()),JSON.stringify(n())});return()=>{Ee(s)}}function Rt(e){return typeof e=="object"?JSON.parse(JSON.stringify(e)):e}function zc(e){(Array.isArray(e)?e:[e]).forEach(n=>n(Ue))}var Q={},_r=!1;function Wc(e,t){if(_r||(Q=we(Q),_r=!0),t===void 0)return Q[e];Q[e]=t,Oi(Q[e]),typeof t=="object"&&t!==null&&t.hasOwnProperty("init")&&typeof t.init=="function"&&Q[e].init()}function Jc(){return Q}var so={};function Gc(e,t){let n=typeof t!="function"?()=>t:t;return e instanceof Element?ao(e,n()):(so[e]=n,()=>{})}function Xc(e){return Object.entries(so).forEach(([t,n])=>{Object.defineProperty(e,t,{get(){return(...r)=>n(...r)}})}),e}function ao(e,t,n){let r=[];for(;r.length;)r.pop()();let i=Object.entries(t).map(([s,a])=>({name:s,value:a})),o=ki(i);return i=i.map(s=>o.find(a=>a.name===s.name)?{name:`x-bind:${s.name}`,value:`"${s.value}"`}:s),Dn(e,i,n).map(s=>{r.push(s.runCleanups),s()}),()=>{for(;r.length;)r.pop()()}}var co={};function Yc(e,t){co[e]=t}function Zc(e,t){return Object.entries(co).forEach(([n,r])=>{Object.defineProperty(e,n,{get(){return(...i)=>r.bind(t)(...i)},enumerable:!1})}),e}var Qc={get reactive(){return we},get release(){return Ee},get effect(){return he},get raw(){return bi},version:"3.14.8",flushAndStopDeferringMutations:tc,dontAutoEvaluateFunctions:Ri,disableEffectScheduling:Ja,startObservingMutations:On,stopObservingMutations:xi,setReactivityEngine:Ga,onAttributeRemoved:vi,onAttributesAdded:Si,closestDataStack:me,skipDuringClone:Z,onlyDuringClone:Rc,addRootSelector:Vi,addInitSelector:zi,interceptClone:bt,addScopeToNode:je,deferMutations:ec,mapAttributes:Nn,evaluateLater:D,interceptInit:yc,setEvaluator:ac,mergeProxies:He,extractProp:Vc,findClosest:ve,onElRemoved:An,closestRoot:gt,destroyTree:Ae,interceptor:Ci,transition:cn,setStyles:mt,mutateDom:A,directive:C,entangle:oo,throttle:io,debounce:ro,evaluate:se,initTree:K,nextTick:Mn,prefixed:Se,prefix:fc,plugin:zc,magic:F,store:Wc,start:bc,clone:Nc,cloneNode:Dc,bound:Kc,$data:Ti,watch:_i,walk:le,data:Yc,bind:Gc},Ue=Qc;function eu(e,t){const n=Object.create(null),r=e.split(",");for(let i=0;i<r.length;i++)n[r[i]]=!0;return i=>!!n[i]}var tu=Object.freeze({}),nu=Object.prototype.hasOwnProperty,_t=(e,t)=>nu.call(e,t),ae=Array.isArray,Ne=e=>uo(e)==="[object Map]",ru=e=>typeof e=="string",Fn=e=>typeof e=="symbol",yt=e=>e!==null&&typeof e=="object",iu=Object.prototype.toString,uo=e=>iu.call(e),lo=e=>uo(e).slice(8,-1),Ln=e=>ru(e)&&e!=="NaN"&&e[0]!=="-"&&""+parseInt(e,10)===e,ou=e=>{const t=Object.create(null);return n=>t[n]||(t[n]=e(n))},su=ou(e=>e.charAt(0).toUpperCase()+e.slice(1)),fo=(e,t)=>e!==t&&(e===e||t===t),ln=new WeakMap,Ie=[],H,ce=Symbol("iterate"),fn=Symbol("Map key iterate");function au(e){return e&&e._isEffect===!0}function cu(e,t=tu){au(e)&&(e=e.raw);const n=fu(e,t);return t.lazy||n(),n}function uu(e){e.active&&(po(e),e.options.onStop&&e.options.onStop(),e.active=!1)}var lu=0;function fu(e,t){const n=function(){if(!n.active)return e();if(!Ie.includes(n)){po(n);try{return pu(),Ie.push(n),H=n,e()}finally{Ie.pop(),ho(),H=Ie[Ie.length-1]}}};return n.id=lu++,n.allowRecurse=!!t.allowRecurse,n._isEffect=!0,n.active=!0,n.raw=e,n.deps=[],n.options=t,n}function po(e){const{deps:t}=e;if(t.length){for(let n=0;n<t.length;n++)t[n].delete(e);t.length=0}}var be=!0,jn=[];function du(){jn.push(be),be=!1}function pu(){jn.push(be),be=!0}function ho(){const e=jn.pop();be=e===void 0?!0:e}function B(e,t,n){if(!be||H===void 0)return;let r=ln.get(e);r||ln.set(e,r=new Map);let i=r.get(n);i||r.set(n,i=new Set),i.has(H)||(i.add(H),H.deps.push(i),H.options.onTrack&&H.options.onTrack({effect:H,target:e,type:t,key:n}))}function X(e,t,n,r,i,o){const s=ln.get(e);if(!s)return;const a=new Set,c=l=>{l&&l.forEach(p=>{(p!==H||p.allowRecurse)&&a.add(p)})};if(t==="clear")s.forEach(c);else if(n==="length"&&ae(e))s.forEach((l,p)=>{(p==="length"||p>=r)&&c(l)});else switch(n!==void 0&&c(s.get(n)),t){case"add":ae(e)?Ln(n)&&c(s.get("length")):(c(s.get(ce)),Ne(e)&&c(s.get(fn)));break;case"delete":ae(e)||(c(s.get(ce)),Ne(e)&&c(s.get(fn)));break;case"set":Ne(e)&&c(s.get(ce));break}const u=l=>{l.options.onTrigger&&l.options.onTrigger({effect:l,target:e,key:n,type:t,newValue:r,oldValue:i,oldTarget:o}),l.options.scheduler?l.options.scheduler(l):l()};a.forEach(u)}var hu=eu("__proto__,__v_isRef,__isVue"),go=new Set(Object.getOwnPropertyNames(Symbol).map(e=>Symbol[e]).filter(Fn)),gu=mo(),mu=mo(!0),yr=bu();function bu(){const e={};return["includes","indexOf","lastIndexOf"].forEach(t=>{e[t]=function(...n){const r=v(this);for(let o=0,s=this.length;o<s;o++)B(r,"get",o+"");const i=r[t](...n);return i===-1||i===!1?r[t](...n.map(v)):i}}),["push","pop","shift","unshift","splice"].forEach(t=>{e[t]=function(...n){du();const r=v(this)[t].apply(this,n);return ho(),r}}),e}function mo(e=!1,t=!1){return function(r,i,o){if(i==="__v_isReactive")return!e;if(i==="__v_isReadonly")return e;if(i==="__v_raw"&&o===(e?t?Du:wo:t?Ru:yo).get(r))return r;const s=ae(r);if(!e&&s&&_t(yr,i))return Reflect.get(yr,i,o);const a=Reflect.get(r,i,o);return(Fn(i)?go.has(i):hu(i))||(e||B(r,"get",i),t)?a:dn(a)?!s||!Ln(i)?a.value:a:yt(a)?e?Eo(a):Kn(a):a}}var _u=yu();function yu(e=!1){return function(n,r,i,o){let s=n[r];if(!e&&(i=v(i),s=v(s),!ae(n)&&dn(s)&&!dn(i)))return s.value=i,!0;const a=ae(n)&&Ln(r)?Number(r)<n.length:_t(n,r),c=Reflect.set(n,r,i,o);return n===v(o)&&(a?fo(i,s)&&X(n,"set",r,i,s):X(n,"add",r,i)),c}}function wu(e,t){const n=_t(e,t),r=e[t],i=Reflect.deleteProperty(e,t);return i&&n&&X(e,"delete",t,void 0,r),i}function Eu(e,t){const n=Reflect.has(e,t);return(!Fn(t)||!go.has(t))&&B(e,"has",t),n}function Su(e){return B(e,"iterate",ae(e)?"length":ce),Reflect.ownKeys(e)}var vu={get:gu,set:_u,deleteProperty:wu,has:Eu,ownKeys:Su},Au={get:mu,set(e,t){return console.warn(`Set operation on key "${String(t)}" failed: target is readonly.`,e),!0},deleteProperty(e,t){return console.warn(`Delete operation on key "${String(t)}" failed: target is readonly.`,e),!0}},Hn=e=>yt(e)?Kn(e):e,Un=e=>yt(e)?Eo(e):e,qn=e=>e,wt=e=>Reflect.getPrototypeOf(e);function Ke(e,t,n=!1,r=!1){e=e.__v_raw;const i=v(e),o=v(t);t!==o&&!n&&B(i,"get",t),!n&&B(i,"get",o);const{has:s}=wt(i),a=r?qn:n?Un:Hn;if(s.call(i,t))return a(e.get(t));if(s.call(i,o))return a(e.get(o));e!==i&&e.get(t)}function Ve(e,t=!1){const n=this.__v_raw,r=v(n),i=v(e);return e!==i&&!t&&B(r,"has",e),!t&&B(r,"has",i),e===i?n.has(e):n.has(e)||n.has(i)}function ze(e,t=!1){return e=e.__v_raw,!t&&B(v(e),"iterate",ce),Reflect.get(e,"size",e)}function wr(e){e=v(e);const t=v(this);return wt(t).has.call(t,e)||(t.add(e),X(t,"add",e,e)),this}function Er(e,t){t=v(t);const n=v(this),{has:r,get:i}=wt(n);let o=r.call(n,e);o?_o(n,r,e):(e=v(e),o=r.call(n,e));const s=i.call(n,e);return n.set(e,t),o?fo(t,s)&&X(n,"set",e,t,s):X(n,"add",e,t),this}function Sr(e){const t=v(this),{has:n,get:r}=wt(t);let i=n.call(t,e);i?_o(t,n,e):(e=v(e),i=n.call(t,e));const o=r?r.call(t,e):void 0,s=t.delete(e);return i&&X(t,"delete",e,void 0,o),s}function vr(){const e=v(this),t=e.size!==0,n=Ne(e)?new Map(e):new Set(e),r=e.clear();return t&&X(e,"clear",void 0,void 0,n),r}function We(e,t){return function(r,i){const o=this,s=o.__v_raw,a=v(s),c=t?qn:e?Un:Hn;return!e&&B(a,"iterate",ce),s.forEach((u,l)=>r.call(i,c(u),c(l),o))}}function Je(e,t,n){return function(...r){const i=this.__v_raw,o=v(i),s=Ne(o),a=e==="entries"||e===Symbol.iterator&&s,c=e==="keys"&&s,u=i[e](...r),l=n?qn:t?Un:Hn;return!t&&B(o,"iterate",c?fn:ce),{next(){const{value:p,done:h}=u.next();return h?{value:p,done:h}:{value:a?[l(p[0]),l(p[1])]:l(p),done:h}},[Symbol.iterator](){return this}}}}function z(e){return function(...t){{const n=t[0]?`on key "${t[0]}" `:"";console.warn(`${su(e)} operation ${n}failed: target is readonly.`,v(this))}return e==="delete"?!1:this}}function xu(){const e={get(o){return Ke(this,o)},get size(){return ze(this)},has:Ve,add:wr,set:Er,delete:Sr,clear:vr,forEach:We(!1,!1)},t={get(o){return Ke(this,o,!1,!0)},get size(){return ze(this)},has:Ve,add:wr,set:Er,delete:Sr,clear:vr,forEach:We(!1,!0)},n={get(o){return Ke(this,o,!0)},get size(){return ze(this,!0)},has(o){return Ve.call(this,o,!0)},add:z("add"),set:z("set"),delete:z("delete"),clear:z("clear"),forEach:We(!0,!1)},r={get(o){return Ke(this,o,!0,!0)},get size(){return ze(this,!0)},has(o){return Ve.call(this,o,!0)},add:z("add"),set:z("set"),delete:z("delete"),clear:z("clear"),forEach:We(!0,!0)};return["keys","values","entries",Symbol.iterator].forEach(o=>{e[o]=Je(o,!1,!1),n[o]=Je(o,!0,!1),t[o]=Je(o,!1,!0),r[o]=Je(o,!0,!0)}),[e,n,t,r]}var[Tu,Ou,wp,Ep]=xu();function bo(e,t){const n=e?Ou:Tu;return(r,i,o)=>i==="__v_isReactive"?!e:i==="__v_isReadonly"?e:i==="__v_raw"?r:Reflect.get(_t(n,i)&&i in r?n:r,i,o)}var Cu={get:bo(!1)},Iu={get:bo(!0)};function _o(e,t,n){const r=v(n);if(r!==n&&t.call(e,r)){const i=lo(e);console.warn(`Reactive ${i} contains both the raw and reactive versions of the same object${i==="Map"?" as keys":""}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`)}}var yo=new WeakMap,Ru=new WeakMap,wo=new WeakMap,Du=new WeakMap;function Nu(e){switch(e){case"Object":case"Array":return 1;case"Map":case"Set":case"WeakMap":case"WeakSet":return 2;default:return 0}}function ku(e){return e.__v_skip||!Object.isExtensible(e)?0:Nu(lo(e))}function Kn(e){return e&&e.__v_isReadonly?e:So(e,!1,vu,Cu,yo)}function Eo(e){return So(e,!0,Au,Iu,wo)}function So(e,t,n,r,i){if(!yt(e))return console.warn(`value cannot be made reactive: ${String(e)}`),e;if(e.__v_raw&&!(t&&e.__v_isReactive))return e;const o=i.get(e);if(o)return o;const s=ku(e);if(s===0)return e;const a=new Proxy(e,s===2?r:n);return i.set(e,a),a}function v(e){return e&&v(e.__v_raw)||e}function dn(e){return!!(e&&e.__v_isRef===!0)}F("nextTick",()=>Mn);F("dispatch",e=>De.bind(De,e));F("watch",(e,{evaluateLater:t,cleanup:n})=>(r,i)=>{let o=t(r),a=_i(()=>{let c;return o(u=>c=u),c},i);n(a)});F("store",Jc);F("data",e=>Ti(e));F("root",e=>gt(e));F("refs",e=>(e._x_refs_proxy||(e._x_refs_proxy=He(Pu(e))),e._x_refs_proxy));function Pu(e){let t=[];return ve(e,n=>{n._x_refs&&t.push(n._x_refs)}),t}var Dt={};function vo(e){return Dt[e]||(Dt[e]=0),++Dt[e]}function Mu(e,t){return ve(e,n=>{if(n._x_ids&&n._x_ids[t])return!0})}function Bu(e,t){e._x_ids||(e._x_ids={}),e._x_ids[t]||(e._x_ids[t]=vo(t))}F("id",(e,{cleanup:t})=>(n,r=null)=>{let i=`${n}${r?`-${r}`:""}`;return $u(e,i,t,()=>{let o=Mu(e,n),s=o?o._x_ids[n]:vo(n);return r?`${n}-${s}-${r}`:`${n}-${s}`})});bt((e,t)=>{e._x_id&&(t._x_id=e._x_id)});function $u(e,t,n,r){if(e._x_id||(e._x_id={}),e._x_id[t])return e._x_id[t];let i=r();return e._x_id[t]=i,n(()=>{delete e._x_id[t]}),i}F("el",e=>e);Ao("Focus","focus","focus");Ao("Persist","persist","persist");function Ao(e,t,n){F(t,r=>M(`You can't use [$${t}] without first installing the "${e}" plugin here: https://alpinejs.dev/plugins/${n}`,r))}C("modelable",(e,{expression:t},{effect:n,evaluateLater:r,cleanup:i})=>{let o=r(t),s=()=>{let l;return o(p=>l=p),l},a=r(`${t} = __placeholder`),c=l=>a(()=>{},{scope:{__placeholder:l}}),u=s();c(u),queueMicrotask(()=>{if(!e._x_model)return;e._x_removeModelListeners.default();let l=e._x_model.get,p=e._x_model.set,h=oo({get(){return l()},set(_){p(_)}},{get(){return s()},set(_){c(_)}});i(h)})});C("teleport",(e,{modifiers:t,expression:n},{cleanup:r})=>{e.tagName.toLowerCase()!=="template"&&M("x-teleport can only be used on a <template> tag",e);let i=Ar(n),o=e.content.cloneNode(!0).firstElementChild;e._x_teleport=o,o._x_teleportBack=e,e.setAttribute("data-teleport-template",!0),o.setAttribute("data-teleport-target",!0),e._x_forwardEvents&&e._x_forwardEvents.forEach(a=>{o.addEventListener(a,c=>{c.stopPropagation(),e.dispatchEvent(new c.constructor(c.type,c))})}),je(o,{},e);let s=(a,c,u)=>{u.includes("prepend")?c.parentNode.insertBefore(a,c):u.includes("append")?c.parentNode.insertBefore(a,c.nextSibling):c.appendChild(a)};A(()=>{s(o,i,t),Z(()=>{K(o)})()}),e._x_teleportPutBack=()=>{let a=Ar(n);A(()=>{s(e._x_teleport,a,t)})},r(()=>A(()=>{o.remove(),Ae(o)}))});var Fu=document.createElement("div");function Ar(e){let t=Z(()=>document.querySelector(e),()=>Fu)();return t||M(`Cannot find x-teleport element for selector: "${e}"`),t}var xo=()=>{};xo.inline=(e,{modifiers:t},{cleanup:n})=>{t.includes("self")?e._x_ignoreSelf=!0:e._x_ignore=!0,n(()=>{t.includes("self")?delete e._x_ignoreSelf:delete e._x_ignore})};C("ignore",xo);C("effect",Z((e,{expression:t},{effect:n})=>{n(D(e,t))}));function pn(e,t,n,r){let i=e,o=c=>r(c),s={},a=(c,u)=>l=>u(c,l);if(n.includes("dot")&&(t=Lu(t)),n.includes("camel")&&(t=ju(t)),n.includes("passive")&&(s.passive=!0),n.includes("capture")&&(s.capture=!0),n.includes("window")&&(i=window),n.includes("document")&&(i=document),n.includes("debounce")){let c=n[n.indexOf("debounce")+1]||"invalid-wait",u=ot(c.split("ms")[0])?Number(c.split("ms")[0]):250;o=ro(o,u)}if(n.includes("throttle")){let c=n[n.indexOf("throttle")+1]||"invalid-wait",u=ot(c.split("ms")[0])?Number(c.split("ms")[0]):250;o=io(o,u)}return n.includes("prevent")&&(o=a(o,(c,u)=>{u.preventDefault(),c(u)})),n.includes("stop")&&(o=a(o,(c,u)=>{u.stopPropagation(),c(u)})),n.includes("once")&&(o=a(o,(c,u)=>{c(u),i.removeEventListener(t,o,s)})),(n.includes("away")||n.includes("outside"))&&(i=document,o=a(o,(c,u)=>{e.contains(u.target)||u.target.isConnected!==!1&&(e.offsetWidth<1&&e.offsetHeight<1||e._x_isShown!==!1&&c(u))})),n.includes("self")&&(o=a(o,(c,u)=>{u.target===e&&c(u)})),(Uu(t)||To(t))&&(o=a(o,(c,u)=>{qu(u,n)||c(u)})),i.addEventListener(t,o,s),()=>{i.removeEventListener(t,o,s)}}function Lu(e){return e.replace(/-/g,".")}function ju(e){return e.toLowerCase().replace(/-(\w)/g,(t,n)=>n.toUpperCase())}function ot(e){return!Array.isArray(e)&&!isNaN(e)}function Hu(e){return[" ","_"].includes(e)?e:e.replace(/([a-z])([A-Z])/g,"$1-$2").replace(/[_\s]/,"-").toLowerCase()}function Uu(e){return["keydown","keyup"].includes(e)}function To(e){return["contextmenu","click","mouse"].some(t=>e.includes(t))}function qu(e,t){let n=t.filter(o=>!["window","document","prevent","stop","once","capture","self","away","outside","passive"].includes(o));if(n.includes("debounce")){let o=n.indexOf("debounce");n.splice(o,ot((n[o+1]||"invalid-wait").split("ms")[0])?2:1)}if(n.includes("throttle")){let o=n.indexOf("throttle");n.splice(o,ot((n[o+1]||"invalid-wait").split("ms")[0])?2:1)}if(n.length===0||n.length===1&&xr(e.key).includes(n[0]))return!1;const i=["ctrl","shift","alt","meta","cmd","super"].filter(o=>n.includes(o));return n=n.filter(o=>!i.includes(o)),!(i.length>0&&i.filter(s=>((s==="cmd"||s==="super")&&(s="meta"),e[`${s}Key`])).length===i.length&&(To(e.type)||xr(e.key).includes(n[0])))}function xr(e){if(!e)return[];e=Hu(e);let t={ctrl:"control",slash:"/",space:" ",spacebar:" ",cmd:"meta",esc:"escape",up:"arrow-up",down:"arrow-down",left:"arrow-left",right:"arrow-right",period:".",comma:",",equal:"=",minus:"-",underscore:"_"};return t[e]=e,Object.keys(t).map(n=>{if(t[n]===e)return n}).filter(n=>n)}C("model",(e,{modifiers:t,expression:n},{effect:r,cleanup:i})=>{let o=e;t.includes("parent")&&(o=e.parentNode);let s=D(o,n),a;typeof n=="string"?a=D(o,`${n} = __placeholder`):typeof n=="function"&&typeof n()=="string"?a=D(o,`${n()} = __placeholder`):a=()=>{};let c=()=>{let h;return s(_=>h=_),Tr(h)?h.get():h},u=h=>{let _;s(g=>_=g),Tr(_)?_.set(h):a(()=>{},{scope:{__placeholder:h}})};typeof n=="string"&&e.type==="radio"&&A(()=>{e.hasAttribute("name")||e.setAttribute("name",n)});var l=e.tagName.toLowerCase()==="select"||["checkbox","radio"].includes(e.type)||t.includes("lazy")?"change":"input";let p=G?()=>{}:pn(e,l,t,h=>{u(Nt(e,t,h,c()))});if(t.includes("fill")&&([void 0,null,""].includes(c())||$n(e)&&Array.isArray(c())||e.tagName.toLowerCase()==="select"&&e.multiple)&&u(Nt(e,t,{target:e},c())),e._x_removeModelListeners||(e._x_removeModelListeners={}),e._x_removeModelListeners.default=p,i(()=>e._x_removeModelListeners.default()),e.form){let h=pn(e.form,"reset",[],_=>{Mn(()=>e._x_model&&e._x_model.set(Nt(e,t,{target:e},c())))});i(()=>h())}e._x_model={get(){return c()},set(h){u(h)}},e._x_forceModelUpdate=h=>{h===void 0&&typeof n=="string"&&n.match(/\./)&&(h=""),window.fromModel=!0,A(()=>Zi(e,"value",h)),delete window.fromModel},r(()=>{let h=c();t.includes("unintrusive")&&document.activeElement.isSameNode(e)||e._x_forceModelUpdate(h)})});function Nt(e,t,n,r){return A(()=>{if(n instanceof CustomEvent&&n.detail!==void 0)return n.detail!==null&&n.detail!==void 0?n.detail:n.target.value;if($n(e))if(Array.isArray(r)){let i=null;return t.includes("number")?i=kt(n.target.value):t.includes("boolean")?i=Qe(n.target.value):i=n.target.value,n.target.checked?r.includes(i)?r:r.concat([i]):r.filter(o=>!Ku(o,i))}else return n.target.checked;else{if(e.tagName.toLowerCase()==="select"&&e.multiple)return t.includes("number")?Array.from(n.target.selectedOptions).map(i=>{let o=i.value||i.text;return kt(o)}):t.includes("boolean")?Array.from(n.target.selectedOptions).map(i=>{let o=i.value||i.text;return Qe(o)}):Array.from(n.target.selectedOptions).map(i=>i.value||i.text);{let i;return no(e)?n.target.checked?i=n.target.value:i=r:i=n.target.value,t.includes("number")?kt(i):t.includes("boolean")?Qe(i):t.includes("trim")?i.trim():i}}})}function kt(e){let t=e?parseFloat(e):null;return Vu(t)?t:e}function Ku(e,t){return e==t}function Vu(e){return!Array.isArray(e)&&!isNaN(e)}function Tr(e){return e!==null&&typeof e=="object"&&typeof e.get=="function"&&typeof e.set=="function"}C("cloak",e=>queueMicrotask(()=>A(()=>e.removeAttribute(Se("cloak")))));zi(()=>`[${Se("init")}]`);C("init",Z((e,{expression:t},{evaluate:n})=>typeof t=="string"?!!t.trim()&&n(t,{},!1):n(t,{},!1)));C("text",(e,{expression:t},{effect:n,evaluateLater:r})=>{let i=r(t);n(()=>{i(o=>{A(()=>{e.textContent=o})})})});C("html",(e,{expression:t},{effect:n,evaluateLater:r})=>{let i=r(t);n(()=>{i(o=>{A(()=>{e.innerHTML=o,e._x_ignoreSelf=!0,K(e),delete e._x_ignoreSelf})})})});Nn(Bi(":",$i(Se("bind:"))));var Oo=(e,{value:t,modifiers:n,expression:r,original:i},{effect:o,cleanup:s})=>{if(!t){let c={};Xc(c),D(e,r)(l=>{ao(e,l,i)},{scope:c});return}if(t==="key")return zu(e,r);if(e._x_inlineBindings&&e._x_inlineBindings[t]&&e._x_inlineBindings[t].extract)return;let a=D(e,r);o(()=>a(c=>{c===void 0&&typeof r=="string"&&r.match(/\./)&&(c=""),A(()=>Zi(e,t,c,n))})),s(()=>{e._x_undoAddedClasses&&e._x_undoAddedClasses(),e._x_undoAddedStyles&&e._x_undoAddedStyles()})};Oo.inline=(e,{value:t,modifiers:n,expression:r})=>{t&&(e._x_inlineBindings||(e._x_inlineBindings={}),e._x_inlineBindings[t]={expression:r,extract:!1})};C("bind",Oo);function zu(e,t){e._x_keyExpression=t}Vi(()=>`[${Se("data")}]`);C("data",(e,{expression:t},{cleanup:n})=>{if(Wu(e))return;t=t===""?"{}":t;let r={};tn(r,e);let i={};Zc(i,r);let o=se(e,t,{scope:i});(o===void 0||o===!0)&&(o={}),tn(o,e);let s=we(o);Oi(s);let a=je(e,s);s.init&&se(e,s.init),n(()=>{s.destroy&&se(e,s.destroy),a()})});bt((e,t)=>{e._x_dataStack&&(t._x_dataStack=e._x_dataStack,t.setAttribute("data-has-alpine-state",!0))});function Wu(e){return G?un?!0:e.hasAttribute("data-has-alpine-state"):!1}C("show",(e,{modifiers:t,expression:n},{effect:r})=>{let i=D(e,n);e._x_doHide||(e._x_doHide=()=>{A(()=>{e.style.setProperty("display","none",t.includes("important")?"important":void 0)})}),e._x_doShow||(e._x_doShow=()=>{A(()=>{e.style.length===1&&e.style.display==="none"?e.removeAttribute("style"):e.style.removeProperty("display")})});let o=()=>{e._x_doHide(),e._x_isShown=!1},s=()=>{e._x_doShow(),e._x_isShown=!0},a=()=>setTimeout(s),c=an(p=>p?s():o(),p=>{typeof e._x_toggleAndCascadeWithTransitions=="function"?e._x_toggleAndCascadeWithTransitions(e,p,s,o):p?a():o()}),u,l=!0;r(()=>i(p=>{!l&&p===u||(t.includes("immediate")&&(p?a():o()),c(p),u=p,l=!1)}))});C("for",(e,{expression:t},{effect:n,cleanup:r})=>{let i=Gu(t),o=D(e,i.items),s=D(e,e._x_keyExpression||"index");e._x_prevKeys=[],e._x_lookup={},n(()=>Ju(e,i,o,s)),r(()=>{Object.values(e._x_lookup).forEach(a=>A(()=>{Ae(a),a.remove()})),delete e._x_prevKeys,delete e._x_lookup})});function Ju(e,t,n,r){let i=s=>typeof s=="object"&&!Array.isArray(s),o=e;n(s=>{Xu(s)&&s>=0&&(s=Array.from(Array(s).keys(),d=>d+1)),s===void 0&&(s=[]);let a=e._x_lookup,c=e._x_prevKeys,u=[],l=[];if(i(s))s=Object.entries(s).map(([d,m])=>{let w=Or(t,m,d,s);r(E=>{l.includes(E)&&M("Duplicate key on x-for",e),l.push(E)},{scope:{index:d,...w}}),u.push(w)});else for(let d=0;d<s.length;d++){let m=Or(t,s[d],d,s);r(w=>{l.includes(w)&&M("Duplicate key on x-for",e),l.push(w)},{scope:{index:d,...m}}),u.push(m)}let p=[],h=[],_=[],g=[];for(let d=0;d<c.length;d++){let m=c[d];l.indexOf(m)===-1&&_.push(m)}c=c.filter(d=>!_.includes(d));let b="template";for(let d=0;d<l.length;d++){let m=l[d],w=c.indexOf(m);if(w===-1)c.splice(d,0,m),p.push([b,d]);else if(w!==d){let E=c.splice(d,1)[0],x=c.splice(w-1,1)[0];c.splice(d,0,x),c.splice(w,0,E),h.push([E,x])}else g.push(m);b=m}for(let d=0;d<_.length;d++){let m=_[d];m in a&&(A(()=>{Ae(a[m]),a[m].remove()}),delete a[m])}for(let d=0;d<h.length;d++){let[m,w]=h[d],E=a[m],x=a[w],T=document.createElement("div");A(()=>{x||M('x-for ":key" is undefined or invalid',o,w,a),x.after(T),E.after(x),x._x_currentIfEl&&x.after(x._x_currentIfEl),T.before(E),E._x_currentIfEl&&E.after(E._x_currentIfEl),T.remove()}),x._x_refreshXForScope(u[l.indexOf(w)])}for(let d=0;d<p.length;d++){let[m,w]=p[d],E=m==="template"?o:a[m];E._x_currentIfEl&&(E=E._x_currentIfEl);let x=u[w],T=l[w],N=document.importNode(o.content,!0).firstElementChild,L=we(x);je(N,L,o),N._x_refreshXForScope=ge=>{Object.entries(ge).forEach(([qe,ds])=>{L[qe]=ds})},A(()=>{E.after(N),Z(()=>K(N))()}),typeof T=="object"&&M("x-for key cannot be an object, it must be a string or an integer",o),a[T]=N}for(let d=0;d<g.length;d++)a[g[d]]._x_refreshXForScope(u[l.indexOf(g[d])]);o._x_prevKeys=l})}function Gu(e){let t=/,([^,\}\]]*)(?:,([^,\}\]]*))?$/,n=/^\s*\(|\)\s*$/g,r=/([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/,i=e.match(r);if(!i)return;let o={};o.items=i[2].trim();let s=i[1].replace(n,"").trim(),a=s.match(t);return a?(o.item=s.replace(t,"").trim(),o.index=a[1].trim(),a[2]&&(o.collection=a[2].trim())):o.item=s,o}function Or(e,t,n,r){let i={};return/^\[.*\]$/.test(e.item)&&Array.isArray(t)?e.item.replace("[","").replace("]","").split(",").map(s=>s.trim()).forEach((s,a)=>{i[s]=t[a]}):/^\{.*\}$/.test(e.item)&&!Array.isArray(t)&&typeof t=="object"?e.item.replace("{","").replace("}","").split(",").map(s=>s.trim()).forEach(s=>{i[s]=t[s]}):i[e.item]=t,e.index&&(i[e.index]=n),e.collection&&(i[e.collection]=r),i}function Xu(e){return!Array.isArray(e)&&!isNaN(e)}function Co(){}Co.inline=(e,{expression:t},{cleanup:n})=>{let r=gt(e);r._x_refs||(r._x_refs={}),r._x_refs[t]=e,n(()=>delete r._x_refs[t])};C("ref",Co);C("if",(e,{expression:t},{effect:n,cleanup:r})=>{e.tagName.toLowerCase()!=="template"&&M("x-if can only be used on a <template> tag",e);let i=D(e,t),o=()=>{if(e._x_currentIfEl)return e._x_currentIfEl;let a=e.content.cloneNode(!0).firstElementChild;return je(a,{},e),A(()=>{e.after(a),Z(()=>K(a))()}),e._x_currentIfEl=a,e._x_undoIf=()=>{A(()=>{Ae(a),a.remove()}),delete e._x_currentIfEl},a},s=()=>{e._x_undoIf&&(e._x_undoIf(),delete e._x_undoIf)};n(()=>i(a=>{a?o():s()})),r(()=>e._x_undoIf&&e._x_undoIf())});C("id",(e,{expression:t},{evaluate:n})=>{n(t).forEach(i=>Bu(e,i))});bt((e,t)=>{e._x_ids&&(t._x_ids=e._x_ids)});Nn(Bi("@",$i(Se("on:"))));C("on",Z((e,{value:t,modifiers:n,expression:r},{cleanup:i})=>{let o=r?D(e,r):()=>{};e.tagName.toLowerCase()==="template"&&(e._x_forwardEvents||(e._x_forwardEvents=[]),e._x_forwardEvents.includes(t)||e._x_forwardEvents.push(t));let s=pn(e,t,n,a=>{o(()=>{},{scope:{$event:a},params:[a]})});i(()=>s())}));Et("Collapse","collapse","collapse");Et("Intersect","intersect","intersect");Et("Focus","trap","focus");Et("Mask","mask","mask");function Et(e,t,n){C(t,r=>M(`You can't use [x-${t}] without first installing the "${e}" plugin here: https://alpinejs.dev/plugins/${n}`,r))}Ue.setEvaluator(Ni);Ue.setReactivityEngine({reactive:Kn,effect:cu,release:uu,raw:v});var Yu=Ue,Io=Yu;const Zu=()=>{};var Cr={};/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ro=function(e){const t=[];let n=0;for(let r=0;r<e.length;r++){let i=e.charCodeAt(r);i<128?t[n++]=i:i<2048?(t[n++]=i>>6|192,t[n++]=i&63|128):(i&64512)===55296&&r+1<e.length&&(e.charCodeAt(r+1)&64512)===56320?(i=65536+((i&1023)<<10)+(e.charCodeAt(++r)&1023),t[n++]=i>>18|240,t[n++]=i>>12&63|128,t[n++]=i>>6&63|128,t[n++]=i&63|128):(t[n++]=i>>12|224,t[n++]=i>>6&63|128,t[n++]=i&63|128)}return t},Qu=function(e){const t=[];let n=0,r=0;for(;n<e.length;){const i=e[n++];if(i<128)t[r++]=String.fromCharCode(i);else if(i>191&&i<224){const o=e[n++];t[r++]=String.fromCharCode((i&31)<<6|o&63)}else if(i>239&&i<365){const o=e[n++],s=e[n++],a=e[n++],c=((i&7)<<18|(o&63)<<12|(s&63)<<6|a&63)-65536;t[r++]=String.fromCharCode(55296+(c>>10)),t[r++]=String.fromCharCode(56320+(c&1023))}else{const o=e[n++],s=e[n++];t[r++]=String.fromCharCode((i&15)<<12|(o&63)<<6|s&63)}}return t.join("")},Do={byteToCharMap_:null,charToByteMap_:null,byteToCharMapWebSafe_:null,charToByteMapWebSafe_:null,ENCODED_VALS_BASE:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",get ENCODED_VALS(){return this.ENCODED_VALS_BASE+"+/="},get ENCODED_VALS_WEBSAFE(){return this.ENCODED_VALS_BASE+"-_."},HAS_NATIVE_SUPPORT:typeof atob=="function",encodeByteArray(e,t){if(!Array.isArray(e))throw Error("encodeByteArray takes an array as a parameter");this.init_();const n=t?this.byteToCharMapWebSafe_:this.byteToCharMap_,r=[];for(let i=0;i<e.length;i+=3){const o=e[i],s=i+1<e.length,a=s?e[i+1]:0,c=i+2<e.length,u=c?e[i+2]:0,l=o>>2,p=(o&3)<<4|a>>4;let h=(a&15)<<2|u>>6,_=u&63;c||(_=64,s||(h=64)),r.push(n[l],n[p],n[h],n[_])}return r.join("")},encodeString(e,t){return this.HAS_NATIVE_SUPPORT&&!t?btoa(e):this.encodeByteArray(Ro(e),t)},decodeString(e,t){return this.HAS_NATIVE_SUPPORT&&!t?atob(e):Qu(this.decodeStringToByteArray(e,t))},decodeStringToByteArray(e,t){this.init_();const n=t?this.charToByteMapWebSafe_:this.charToByteMap_,r=[];for(let i=0;i<e.length;){const o=n[e.charAt(i++)],a=i<e.length?n[e.charAt(i)]:0;++i;const u=i<e.length?n[e.charAt(i)]:64;++i;const p=i<e.length?n[e.charAt(i)]:64;if(++i,o==null||a==null||u==null||p==null)throw new el;const h=o<<2|a>>4;if(r.push(h),u!==64){const _=a<<4&240|u>>2;if(r.push(_),p!==64){const g=u<<6&192|p;r.push(g)}}}return r},init_(){if(!this.byteToCharMap_){this.byteToCharMap_={},this.charToByteMap_={},this.byteToCharMapWebSafe_={},this.charToByteMapWebSafe_={};for(let e=0;e<this.ENCODED_VALS.length;e++)this.byteToCharMap_[e]=this.ENCODED_VALS.charAt(e),this.charToByteMap_[this.byteToCharMap_[e]]=e,this.byteToCharMapWebSafe_[e]=this.ENCODED_VALS_WEBSAFE.charAt(e),this.charToByteMapWebSafe_[this.byteToCharMapWebSafe_[e]]=e,e>=this.ENCODED_VALS_BASE.length&&(this.charToByteMap_[this.ENCODED_VALS_WEBSAFE.charAt(e)]=e,this.charToByteMapWebSafe_[this.ENCODED_VALS.charAt(e)]=e)}}};class el extends Error{constructor(){super(...arguments),this.name="DecodeBase64StringError"}}const tl=function(e){const t=Ro(e);return Do.encodeByteArray(t,!0)},No=function(e){return tl(e).replace(/\./g,"")},nl=function(e){try{return Do.decodeString(e,!0)}catch(t){console.error("base64Decode failed: ",t)}return null};/**
 * @license
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function rl(){if(typeof self<"u")return self;if(typeof window<"u")return window;if(typeof global<"u")return global;throw new Error("Unable to locate global object.")}/**
 * @license
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const il=()=>rl().__FIREBASE_DEFAULTS__,ol=()=>{if(typeof process>"u"||typeof Cr>"u")return;const e=Cr.__FIREBASE_DEFAULTS__;if(e)return JSON.parse(e)},sl=()=>{if(typeof document>"u")return;let e;try{e=document.cookie.match(/__FIREBASE_DEFAULTS__=([^;]+)/)}catch{return}const t=e&&nl(e[1]);return t&&JSON.parse(t)},al=()=>{try{return Zu()||il()||ol()||sl()}catch(e){console.info(`Unable to get __FIREBASE_DEFAULTS__ due to: ${e}`);return}},ko=()=>{var e;return(e=al())===null||e===void 0?void 0:e.config};/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class cl{constructor(){this.reject=()=>{},this.resolve=()=>{},this.promise=new Promise((t,n)=>{this.resolve=t,this.reject=n})}wrapCallback(t){return(n,r)=>{n?this.reject(n):this.resolve(r),typeof t=="function"&&(this.promise.catch(()=>{}),t.length===1?t(n):t(n,r))}}}function Po(){try{return typeof indexedDB=="object"}catch{return!1}}function Mo(){return new Promise((e,t)=>{try{let n=!0;const r="validate-browser-context-for-indexeddb-analytics-module",i=self.indexedDB.open(r);i.onsuccess=()=>{i.result.close(),n||self.indexedDB.deleteDatabase(r),e(!0)},i.onupgradeneeded=()=>{n=!1},i.onerror=()=>{var o;t(((o=i.error)===null||o===void 0?void 0:o.message)||"")}}catch(n){t(n)}})}function ul(){return!(typeof navigator>"u"||!navigator.cookieEnabled)}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ll="FirebaseError";class xe extends Error{constructor(t,n,r){super(n),this.code=t,this.customData=r,this.name=ll,Object.setPrototypeOf(this,xe.prototype),Error.captureStackTrace&&Error.captureStackTrace(this,St.prototype.create)}}class St{constructor(t,n,r){this.service=t,this.serviceName=n,this.errors=r}create(t,...n){const r=n[0]||{},i=`${this.service}/${t}`,o=this.errors[t],s=o?fl(o,r):"Error",a=`${this.serviceName}: ${s} (${i}).`;return new xe(i,a,r)}}function fl(e,t){return e.replace(dl,(n,r)=>{const i=t[r];return i!=null?String(i):`<${r}?>`})}const dl=/\{\$([^}]+)}/g;function hn(e,t){if(e===t)return!0;const n=Object.keys(e),r=Object.keys(t);for(const i of n){if(!r.includes(i))return!1;const o=e[i],s=t[i];if(Ir(o)&&Ir(s)){if(!hn(o,s))return!1}else if(o!==s)return!1}for(const i of r)if(!n.includes(i))return!1;return!0}function Ir(e){return e!==null&&typeof e=="object"}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Vn(e){return e&&e._delegate?e._delegate:e}class Y{constructor(t,n,r){this.name=t,this.instanceFactory=n,this.type=r,this.multipleInstances=!1,this.serviceProps={},this.instantiationMode="LAZY",this.onInstanceCreated=null}setInstantiationMode(t){return this.instantiationMode=t,this}setMultipleInstances(t){return this.multipleInstances=t,this}setServiceProps(t){return this.serviceProps=t,this}setInstanceCreatedCallback(t){return this.onInstanceCreated=t,this}}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ee="[DEFAULT]";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class pl{constructor(t,n){this.name=t,this.container=n,this.component=null,this.instances=new Map,this.instancesDeferred=new Map,this.instancesOptions=new Map,this.onInitCallbacks=new Map}get(t){const n=this.normalizeInstanceIdentifier(t);if(!this.instancesDeferred.has(n)){const r=new cl;if(this.instancesDeferred.set(n,r),this.isInitialized(n)||this.shouldAutoInitialize())try{const i=this.getOrInitializeService({instanceIdentifier:n});i&&r.resolve(i)}catch{}}return this.instancesDeferred.get(n).promise}getImmediate(t){var n;const r=this.normalizeInstanceIdentifier(t==null?void 0:t.identifier),i=(n=t==null?void 0:t.optional)!==null&&n!==void 0?n:!1;if(this.isInitialized(r)||this.shouldAutoInitialize())try{return this.getOrInitializeService({instanceIdentifier:r})}catch(o){if(i)return null;throw o}else{if(i)return null;throw Error(`Service ${this.name} is not available`)}}getComponent(){return this.component}setComponent(t){if(t.name!==this.name)throw Error(`Mismatching Component ${t.name} for Provider ${this.name}.`);if(this.component)throw Error(`Component for ${this.name} has already been provided`);if(this.component=t,!!this.shouldAutoInitialize()){if(gl(t))try{this.getOrInitializeService({instanceIdentifier:ee})}catch{}for(const[n,r]of this.instancesDeferred.entries()){const i=this.normalizeInstanceIdentifier(n);try{const o=this.getOrInitializeService({instanceIdentifier:i});r.resolve(o)}catch{}}}}clearInstance(t=ee){this.instancesDeferred.delete(t),this.instancesOptions.delete(t),this.instances.delete(t)}async delete(){const t=Array.from(this.instances.values());await Promise.all([...t.filter(n=>"INTERNAL"in n).map(n=>n.INTERNAL.delete()),...t.filter(n=>"_delete"in n).map(n=>n._delete())])}isComponentSet(){return this.component!=null}isInitialized(t=ee){return this.instances.has(t)}getOptions(t=ee){return this.instancesOptions.get(t)||{}}initialize(t={}){const{options:n={}}=t,r=this.normalizeInstanceIdentifier(t.instanceIdentifier);if(this.isInitialized(r))throw Error(`${this.name}(${r}) has already been initialized`);if(!this.isComponentSet())throw Error(`Component ${this.name} has not been registered yet`);const i=this.getOrInitializeService({instanceIdentifier:r,options:n});for(const[o,s]of this.instancesDeferred.entries()){const a=this.normalizeInstanceIdentifier(o);r===a&&s.resolve(i)}return i}onInit(t,n){var r;const i=this.normalizeInstanceIdentifier(n),o=(r=this.onInitCallbacks.get(i))!==null&&r!==void 0?r:new Set;o.add(t),this.onInitCallbacks.set(i,o);const s=this.instances.get(i);return s&&t(s,i),()=>{o.delete(t)}}invokeOnInitCallbacks(t,n){const r=this.onInitCallbacks.get(n);if(r)for(const i of r)try{i(t,n)}catch{}}getOrInitializeService({instanceIdentifier:t,options:n={}}){let r=this.instances.get(t);if(!r&&this.component&&(r=this.component.instanceFactory(this.container,{instanceIdentifier:hl(t),options:n}),this.instances.set(t,r),this.instancesOptions.set(t,n),this.invokeOnInitCallbacks(r,t),this.component.onInstanceCreated))try{this.component.onInstanceCreated(this.container,t,r)}catch{}return r||null}normalizeInstanceIdentifier(t=ee){return this.component?this.component.multipleInstances?t:ee:t}shouldAutoInitialize(){return!!this.component&&this.component.instantiationMode!=="EXPLICIT"}}function hl(e){return e===ee?void 0:e}function gl(e){return e.instantiationMode==="EAGER"}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class ml{constructor(t){this.name=t,this.providers=new Map}addComponent(t){const n=this.getProvider(t.name);if(n.isComponentSet())throw new Error(`Component ${t.name} has already been registered with ${this.name}`);n.setComponent(t)}addOrOverwriteComponent(t){this.getProvider(t.name).isComponentSet()&&this.providers.delete(t.name),this.addComponent(t)}getProvider(t){if(this.providers.has(t))return this.providers.get(t);const n=new pl(t,this);return this.providers.set(t,n),n}getProviders(){return Array.from(this.providers.values())}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */var S;(function(e){e[e.DEBUG=0]="DEBUG",e[e.VERBOSE=1]="VERBOSE",e[e.INFO=2]="INFO",e[e.WARN=3]="WARN",e[e.ERROR=4]="ERROR",e[e.SILENT=5]="SILENT"})(S||(S={}));const bl={debug:S.DEBUG,verbose:S.VERBOSE,info:S.INFO,warn:S.WARN,error:S.ERROR,silent:S.SILENT},_l=S.INFO,yl={[S.DEBUG]:"log",[S.VERBOSE]:"log",[S.INFO]:"info",[S.WARN]:"warn",[S.ERROR]:"error"},wl=(e,t,...n)=>{if(t<e.logLevel)return;const r=new Date().toISOString(),i=yl[t];if(i)console[i](`[${r}]  ${e.name}:`,...n);else throw new Error(`Attempted to log a message with an invalid logType (value: ${t})`)};class El{constructor(t){this.name=t,this._logLevel=_l,this._logHandler=wl,this._userLogHandler=null}get logLevel(){return this._logLevel}set logLevel(t){if(!(t in S))throw new TypeError(`Invalid value "${t}" assigned to \`logLevel\``);this._logLevel=t}setLogLevel(t){this._logLevel=typeof t=="string"?bl[t]:t}get logHandler(){return this._logHandler}set logHandler(t){if(typeof t!="function")throw new TypeError("Value assigned to `logHandler` must be a function");this._logHandler=t}get userLogHandler(){return this._userLogHandler}set userLogHandler(t){this._userLogHandler=t}debug(...t){this._userLogHandler&&this._userLogHandler(this,S.DEBUG,...t),this._logHandler(this,S.DEBUG,...t)}log(...t){this._userLogHandler&&this._userLogHandler(this,S.VERBOSE,...t),this._logHandler(this,S.VERBOSE,...t)}info(...t){this._userLogHandler&&this._userLogHandler(this,S.INFO,...t),this._logHandler(this,S.INFO,...t)}warn(...t){this._userLogHandler&&this._userLogHandler(this,S.WARN,...t),this._logHandler(this,S.WARN,...t)}error(...t){this._userLogHandler&&this._userLogHandler(this,S.ERROR,...t),this._logHandler(this,S.ERROR,...t)}}const Sl=(e,t)=>t.some(n=>e instanceof n);let Rr,Dr;function vl(){return Rr||(Rr=[IDBDatabase,IDBObjectStore,IDBIndex,IDBCursor,IDBTransaction])}function Al(){return Dr||(Dr=[IDBCursor.prototype.advance,IDBCursor.prototype.continue,IDBCursor.prototype.continuePrimaryKey])}const Bo=new WeakMap,gn=new WeakMap,$o=new WeakMap,Pt=new WeakMap,zn=new WeakMap;function xl(e){const t=new Promise((n,r)=>{const i=()=>{e.removeEventListener("success",o),e.removeEventListener("error",s)},o=()=>{n(q(e.result)),i()},s=()=>{r(e.error),i()};e.addEventListener("success",o),e.addEventListener("error",s)});return t.then(n=>{n instanceof IDBCursor&&Bo.set(n,e)}).catch(()=>{}),zn.set(t,e),t}function Tl(e){if(gn.has(e))return;const t=new Promise((n,r)=>{const i=()=>{e.removeEventListener("complete",o),e.removeEventListener("error",s),e.removeEventListener("abort",s)},o=()=>{n(),i()},s=()=>{r(e.error||new DOMException("AbortError","AbortError")),i()};e.addEventListener("complete",o),e.addEventListener("error",s),e.addEventListener("abort",s)});gn.set(e,t)}let mn={get(e,t,n){if(e instanceof IDBTransaction){if(t==="done")return gn.get(e);if(t==="objectStoreNames")return e.objectStoreNames||$o.get(e);if(t==="store")return n.objectStoreNames[1]?void 0:n.objectStore(n.objectStoreNames[0])}return q(e[t])},set(e,t,n){return e[t]=n,!0},has(e,t){return e instanceof IDBTransaction&&(t==="done"||t==="store")?!0:t in e}};function Ol(e){mn=e(mn)}function Cl(e){return e===IDBDatabase.prototype.transaction&&!("objectStoreNames"in IDBTransaction.prototype)?function(t,...n){const r=e.call(Mt(this),t,...n);return $o.set(r,t.sort?t.sort():[t]),q(r)}:Al().includes(e)?function(...t){return e.apply(Mt(this),t),q(Bo.get(this))}:function(...t){return q(e.apply(Mt(this),t))}}function Il(e){return typeof e=="function"?Cl(e):(e instanceof IDBTransaction&&Tl(e),Sl(e,vl())?new Proxy(e,mn):e)}function q(e){if(e instanceof IDBRequest)return xl(e);if(Pt.has(e))return Pt.get(e);const t=Il(e);return t!==e&&(Pt.set(e,t),zn.set(t,e)),t}const Mt=e=>zn.get(e);function vt(e,t,{blocked:n,upgrade:r,blocking:i,terminated:o}={}){const s=indexedDB.open(e,t),a=q(s);return r&&s.addEventListener("upgradeneeded",c=>{r(q(s.result),c.oldVersion,c.newVersion,q(s.transaction),c)}),n&&s.addEventListener("blocked",c=>n(c.oldVersion,c.newVersion,c)),a.then(c=>{o&&c.addEventListener("close",()=>o()),i&&c.addEventListener("versionchange",u=>i(u.oldVersion,u.newVersion,u))}).catch(()=>{}),a}function Bt(e,{blocked:t}={}){const n=indexedDB.deleteDatabase(e);return t&&n.addEventListener("blocked",r=>t(r.oldVersion,r)),q(n).then(()=>{})}const Rl=["get","getKey","getAll","getAllKeys","count"],Dl=["put","add","delete","clear"],$t=new Map;function Nr(e,t){if(!(e instanceof IDBDatabase&&!(t in e)&&typeof t=="string"))return;if($t.get(t))return $t.get(t);const n=t.replace(/FromIndex$/,""),r=t!==n,i=Dl.includes(n);if(!(n in(r?IDBIndex:IDBObjectStore).prototype)||!(i||Rl.includes(n)))return;const o=async function(s,...a){const c=this.transaction(s,i?"readwrite":"readonly");let u=c.store;return r&&(u=u.index(a.shift())),(await Promise.all([u[n](...a),i&&c.done]))[0]};return $t.set(t,o),o}Ol(e=>({...e,get:(t,n,r)=>Nr(t,n)||e.get(t,n,r),has:(t,n)=>!!Nr(t,n)||e.has(t,n)}));/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class Nl{constructor(t){this.container=t}getPlatformInfoString(){return this.container.getProviders().map(n=>{if(kl(n)){const r=n.getImmediate();return`${r.library}/${r.version}`}else return null}).filter(n=>n).join(" ")}}function kl(e){const t=e.getComponent();return(t==null?void 0:t.type)==="VERSION"}const bn="@firebase/app",kr="0.11.2";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const V=new El("@firebase/app"),Pl="@firebase/app-compat",Ml="@firebase/analytics-compat",Bl="@firebase/analytics",$l="@firebase/app-check-compat",Fl="@firebase/app-check",Ll="@firebase/auth",jl="@firebase/auth-compat",Hl="@firebase/database",Ul="@firebase/data-connect",ql="@firebase/database-compat",Kl="@firebase/functions",Vl="@firebase/functions-compat",zl="@firebase/installations",Wl="@firebase/installations-compat",Jl="@firebase/messaging",Gl="@firebase/messaging-compat",Xl="@firebase/performance",Yl="@firebase/performance-compat",Zl="@firebase/remote-config",Ql="@firebase/remote-config-compat",ef="@firebase/storage",tf="@firebase/storage-compat",nf="@firebase/firestore",rf="@firebase/vertexai",of="@firebase/firestore-compat",sf="firebase";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const _n="[DEFAULT]",af={[bn]:"fire-core",[Pl]:"fire-core-compat",[Bl]:"fire-analytics",[Ml]:"fire-analytics-compat",[Fl]:"fire-app-check",[$l]:"fire-app-check-compat",[Ll]:"fire-auth",[jl]:"fire-auth-compat",[Hl]:"fire-rtdb",[Ul]:"fire-data-connect",[ql]:"fire-rtdb-compat",[Kl]:"fire-fn",[Vl]:"fire-fn-compat",[zl]:"fire-iid",[Wl]:"fire-iid-compat",[Jl]:"fire-fcm",[Gl]:"fire-fcm-compat",[Xl]:"fire-perf",[Yl]:"fire-perf-compat",[Zl]:"fire-rc",[Ql]:"fire-rc-compat",[ef]:"fire-gcs",[tf]:"fire-gcs-compat",[nf]:"fire-fst",[of]:"fire-fst-compat",[rf]:"fire-vertex","fire-js":"fire-js",[sf]:"fire-js-all"};/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const st=new Map,cf=new Map,yn=new Map;function Pr(e,t){try{e.container.addComponent(t)}catch(n){V.debug(`Component ${t.name} failed to register with FirebaseApp ${e.name}`,n)}}function fe(e){const t=e.name;if(yn.has(t))return V.debug(`There were multiple attempts to register component ${t}.`),!1;yn.set(t,e);for(const n of st.values())Pr(n,e);for(const n of cf.values())Pr(n,e);return!0}function Wn(e,t){const n=e.container.getProvider("heartbeat").getImmediate({optional:!0});return n&&n.triggerHeartbeat(),e.container.getProvider(t)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const uf={"no-app":"No Firebase App '{$appName}' has been created - call initializeApp() first","bad-app-name":"Illegal App name: '{$appName}'","duplicate-app":"Firebase App named '{$appName}' already exists with different options or config","app-deleted":"Firebase App named '{$appName}' already deleted","server-app-deleted":"Firebase Server App has been deleted","no-options":"Need to provide options, when not being deployed to hosting via source.","invalid-app-argument":"firebase.{$appName}() takes either no argument or a Firebase App instance.","invalid-log-argument":"First argument to `onLog` must be null or a function.","idb-open":"Error thrown when opening IndexedDB. Original error: {$originalErrorMessage}.","idb-get":"Error thrown when reading from IndexedDB. Original error: {$originalErrorMessage}.","idb-set":"Error thrown when writing to IndexedDB. Original error: {$originalErrorMessage}.","idb-delete":"Error thrown when deleting from IndexedDB. Original error: {$originalErrorMessage}.","finalization-registry-not-supported":"FirebaseServerApp deleteOnDeref field defined but the JS runtime does not support FinalizationRegistry.","invalid-server-app-environment":"FirebaseServerApp is not for use in browser environments."},W=new St("app","Firebase",uf);/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class lf{constructor(t,n,r){this._isDeleted=!1,this._options=Object.assign({},t),this._config=Object.assign({},n),this._name=n.name,this._automaticDataCollectionEnabled=n.automaticDataCollectionEnabled,this._container=r,this.container.addComponent(new Y("app",()=>this,"PUBLIC"))}get automaticDataCollectionEnabled(){return this.checkDestroyed(),this._automaticDataCollectionEnabled}set automaticDataCollectionEnabled(t){this.checkDestroyed(),this._automaticDataCollectionEnabled=t}get name(){return this.checkDestroyed(),this._name}get options(){return this.checkDestroyed(),this._options}get config(){return this.checkDestroyed(),this._config}get container(){return this._container}get isDeleted(){return this._isDeleted}set isDeleted(t){this._isDeleted=t}checkDestroyed(){if(this.isDeleted)throw W.create("app-deleted",{appName:this._name})}}function Fo(e,t={}){let n=e;typeof t!="object"&&(t={name:t});const r=Object.assign({name:_n,automaticDataCollectionEnabled:!1},t),i=r.name;if(typeof i!="string"||!i)throw W.create("bad-app-name",{appName:String(i)});if(n||(n=ko()),!n)throw W.create("no-options");const o=st.get(i);if(o){if(hn(n,o.options)&&hn(r,o.config))return o;throw W.create("duplicate-app",{appName:i})}const s=new ml(i);for(const c of yn.values())s.addComponent(c);const a=new lf(n,r,s);return st.set(i,a),a}function ff(e=_n){const t=st.get(e);if(!t&&e===_n&&ko())return Fo();if(!t)throw W.create("no-app",{appName:e});return t}function J(e,t,n){var r;let i=(r=af[e])!==null&&r!==void 0?r:e;n&&(i+=`-${n}`);const o=i.match(/\s|\//),s=t.match(/\s|\//);if(o||s){const a=[`Unable to register library "${i}" with version "${t}":`];o&&a.push(`library name "${i}" contains illegal characters (whitespace or "/")`),o&&s&&a.push("and"),s&&a.push(`version name "${t}" contains illegal characters (whitespace or "/")`),V.warn(a.join(" "));return}fe(new Y(`${i}-version`,()=>({library:i,version:t}),"VERSION"))}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const df="firebase-heartbeat-database",pf=1,Me="firebase-heartbeat-store";let Ft=null;function Lo(){return Ft||(Ft=vt(df,pf,{upgrade:(e,t)=>{switch(t){case 0:try{e.createObjectStore(Me)}catch(n){console.warn(n)}}}}).catch(e=>{throw W.create("idb-open",{originalErrorMessage:e.message})})),Ft}async function hf(e){try{const n=(await Lo()).transaction(Me),r=await n.objectStore(Me).get(jo(e));return await n.done,r}catch(t){if(t instanceof xe)V.warn(t.message);else{const n=W.create("idb-get",{originalErrorMessage:t==null?void 0:t.message});V.warn(n.message)}}}async function Mr(e,t){try{const r=(await Lo()).transaction(Me,"readwrite");await r.objectStore(Me).put(t,jo(e)),await r.done}catch(n){if(n instanceof xe)V.warn(n.message);else{const r=W.create("idb-set",{originalErrorMessage:n==null?void 0:n.message});V.warn(r.message)}}}function jo(e){return`${e.name}!${e.options.appId}`}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const gf=1024,mf=30;class bf{constructor(t){this.container=t,this._heartbeatsCache=null;const n=this.container.getProvider("app").getImmediate();this._storage=new yf(n),this._heartbeatsCachePromise=this._storage.read().then(r=>(this._heartbeatsCache=r,r))}async triggerHeartbeat(){var t,n;try{const i=this.container.getProvider("platform-logger").getImmediate().getPlatformInfoString(),o=Br();if(((t=this._heartbeatsCache)===null||t===void 0?void 0:t.heartbeats)==null&&(this._heartbeatsCache=await this._heartbeatsCachePromise,((n=this._heartbeatsCache)===null||n===void 0?void 0:n.heartbeats)==null)||this._heartbeatsCache.lastSentHeartbeatDate===o||this._heartbeatsCache.heartbeats.some(s=>s.date===o))return;if(this._heartbeatsCache.heartbeats.push({date:o,agent:i}),this._heartbeatsCache.heartbeats.length>mf){const s=wf(this._heartbeatsCache.heartbeats);this._heartbeatsCache.heartbeats.splice(s,1)}return this._storage.overwrite(this._heartbeatsCache)}catch(r){V.warn(r)}}async getHeartbeatsHeader(){var t;try{if(this._heartbeatsCache===null&&await this._heartbeatsCachePromise,((t=this._heartbeatsCache)===null||t===void 0?void 0:t.heartbeats)==null||this._heartbeatsCache.heartbeats.length===0)return"";const n=Br(),{heartbeatsToSend:r,unsentEntries:i}=_f(this._heartbeatsCache.heartbeats),o=No(JSON.stringify({version:2,heartbeats:r}));return this._heartbeatsCache.lastSentHeartbeatDate=n,i.length>0?(this._heartbeatsCache.heartbeats=i,await this._storage.overwrite(this._heartbeatsCache)):(this._heartbeatsCache.heartbeats=[],this._storage.overwrite(this._heartbeatsCache)),o}catch(n){return V.warn(n),""}}}function Br(){return new Date().toISOString().substring(0,10)}function _f(e,t=gf){const n=[];let r=e.slice();for(const i of e){const o=n.find(s=>s.agent===i.agent);if(o){if(o.dates.push(i.date),$r(n)>t){o.dates.pop();break}}else if(n.push({agent:i.agent,dates:[i.date]}),$r(n)>t){n.pop();break}r=r.slice(1)}return{heartbeatsToSend:n,unsentEntries:r}}class yf{constructor(t){this.app=t,this._canUseIndexedDBPromise=this.runIndexedDBEnvironmentCheck()}async runIndexedDBEnvironmentCheck(){return Po()?Mo().then(()=>!0).catch(()=>!1):!1}async read(){if(await this._canUseIndexedDBPromise){const n=await hf(this.app);return n!=null&&n.heartbeats?n:{heartbeats:[]}}else return{heartbeats:[]}}async overwrite(t){var n;if(await this._canUseIndexedDBPromise){const i=await this.read();return Mr(this.app,{lastSentHeartbeatDate:(n=t.lastSentHeartbeatDate)!==null&&n!==void 0?n:i.lastSentHeartbeatDate,heartbeats:t.heartbeats})}else return}async add(t){var n;if(await this._canUseIndexedDBPromise){const i=await this.read();return Mr(this.app,{lastSentHeartbeatDate:(n=t.lastSentHeartbeatDate)!==null&&n!==void 0?n:i.lastSentHeartbeatDate,heartbeats:[...i.heartbeats,...t.heartbeats]})}else return}}function $r(e){return No(JSON.stringify({version:2,heartbeats:e})).length}function wf(e){if(e.length===0)return-1;let t=0,n=e[0].date;for(let r=1;r<e.length;r++)e[r].date<n&&(n=e[r].date,t=r);return t}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Ef(e){fe(new Y("platform-logger",t=>new Nl(t),"PRIVATE")),fe(new Y("heartbeat",t=>new bf(t),"PRIVATE")),J(bn,kr,e),J(bn,kr,"esm2017"),J("fire-js","")}Ef("");var Sf="firebase",vf="11.4.0";/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */J(Sf,vf,"app");const Ho="@firebase/installations",Jn="0.6.13";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Uo=1e4,qo=`w:${Jn}`,Ko="FIS_v2",Af="https://firebaseinstallations.googleapis.com/v1",xf=60*60*1e3,Tf="installations",Of="Installations";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Cf={"missing-app-config-values":'Missing App configuration value: "{$valueName}"',"not-registered":"Firebase Installation is not registered.","installation-not-found":"Firebase Installation not found.","request-failed":'{$requestName} request failed with error "{$serverCode} {$serverStatus}: {$serverMessage}"',"app-offline":"Could not process request. Application offline.","delete-pending-registration":"Can't delete installation while there is a pending registration request."},de=new St(Tf,Of,Cf);function Vo(e){return e instanceof xe&&e.code.includes("request-failed")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function zo({projectId:e}){return`${Af}/projects/${e}/installations`}function Wo(e){return{token:e.token,requestStatus:2,expiresIn:Rf(e.expiresIn),creationTime:Date.now()}}async function Jo(e,t){const r=(await t.json()).error;return de.create("request-failed",{requestName:e,serverCode:r.code,serverMessage:r.message,serverStatus:r.status})}function Go({apiKey:e}){return new Headers({"Content-Type":"application/json",Accept:"application/json","x-goog-api-key":e})}function If(e,{refreshToken:t}){const n=Go(e);return n.append("Authorization",Df(t)),n}async function Xo(e){const t=await e();return t.status>=500&&t.status<600?e():t}function Rf(e){return Number(e.replace("s","000"))}function Df(e){return`${Ko} ${e}`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Nf({appConfig:e,heartbeatServiceProvider:t},{fid:n}){const r=zo(e),i=Go(e),o=t.getImmediate({optional:!0});if(o){const u=await o.getHeartbeatsHeader();u&&i.append("x-firebase-client",u)}const s={fid:n,authVersion:Ko,appId:e.appId,sdkVersion:qo},a={method:"POST",headers:i,body:JSON.stringify(s)},c=await Xo(()=>fetch(r,a));if(c.ok){const u=await c.json();return{fid:u.fid||n,registrationStatus:2,refreshToken:u.refreshToken,authToken:Wo(u.authToken)}}else throw await Jo("Create Installation",c)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Yo(e){return new Promise(t=>{setTimeout(t,e)})}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function kf(e){return btoa(String.fromCharCode(...e)).replace(/\+/g,"-").replace(/\//g,"_")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Pf=/^[cdef][\w-]{21}$/,wn="";function Mf(){try{const e=new Uint8Array(17);(self.crypto||self.msCrypto).getRandomValues(e),e[0]=112+e[0]%16;const n=Bf(e);return Pf.test(n)?n:wn}catch{return wn}}function Bf(e){return kf(e).substr(0,22)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function At(e){return`${e.appName}!${e.appId}`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Zo=new Map;function Qo(e,t){const n=At(e);es(n,t),$f(n,t)}function es(e,t){const n=Zo.get(e);if(n)for(const r of n)r(t)}function $f(e,t){const n=Ff();n&&n.postMessage({key:e,fid:t}),Lf()}let re=null;function Ff(){return!re&&"BroadcastChannel"in self&&(re=new BroadcastChannel("[Firebase] FID Change"),re.onmessage=e=>{es(e.data.key,e.data.fid)}),re}function Lf(){Zo.size===0&&re&&(re.close(),re=null)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const jf="firebase-installations-database",Hf=1,pe="firebase-installations-store";let Lt=null;function Gn(){return Lt||(Lt=vt(jf,Hf,{upgrade:(e,t)=>{switch(t){case 0:e.createObjectStore(pe)}}})),Lt}async function at(e,t){const n=At(e),i=(await Gn()).transaction(pe,"readwrite"),o=i.objectStore(pe),s=await o.get(n);return await o.put(t,n),await i.done,(!s||s.fid!==t.fid)&&Qo(e,t.fid),t}async function ts(e){const t=At(e),r=(await Gn()).transaction(pe,"readwrite");await r.objectStore(pe).delete(t),await r.done}async function xt(e,t){const n=At(e),i=(await Gn()).transaction(pe,"readwrite"),o=i.objectStore(pe),s=await o.get(n),a=t(s);return a===void 0?await o.delete(n):await o.put(a,n),await i.done,a&&(!s||s.fid!==a.fid)&&Qo(e,a.fid),a}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Xn(e){let t;const n=await xt(e.appConfig,r=>{const i=Uf(r),o=qf(e,i);return t=o.registrationPromise,o.installationEntry});return n.fid===wn?{installationEntry:await t}:{installationEntry:n,registrationPromise:t}}function Uf(e){const t=e||{fid:Mf(),registrationStatus:0};return ns(t)}function qf(e,t){if(t.registrationStatus===0){if(!navigator.onLine){const i=Promise.reject(de.create("app-offline"));return{installationEntry:t,registrationPromise:i}}const n={fid:t.fid,registrationStatus:1,registrationTime:Date.now()},r=Kf(e,n);return{installationEntry:n,registrationPromise:r}}else return t.registrationStatus===1?{installationEntry:t,registrationPromise:Vf(e)}:{installationEntry:t}}async function Kf(e,t){try{const n=await Nf(e,t);return at(e.appConfig,n)}catch(n){throw Vo(n)&&n.customData.serverCode===409?await ts(e.appConfig):await at(e.appConfig,{fid:t.fid,registrationStatus:0}),n}}async function Vf(e){let t=await Fr(e.appConfig);for(;t.registrationStatus===1;)await Yo(100),t=await Fr(e.appConfig);if(t.registrationStatus===0){const{installationEntry:n,registrationPromise:r}=await Xn(e);return r||n}return t}function Fr(e){return xt(e,t=>{if(!t)throw de.create("installation-not-found");return ns(t)})}function ns(e){return zf(e)?{fid:e.fid,registrationStatus:0}:e}function zf(e){return e.registrationStatus===1&&e.registrationTime+Uo<Date.now()}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Wf({appConfig:e,heartbeatServiceProvider:t},n){const r=Jf(e,n),i=If(e,n),o=t.getImmediate({optional:!0});if(o){const u=await o.getHeartbeatsHeader();u&&i.append("x-firebase-client",u)}const s={installation:{sdkVersion:qo,appId:e.appId}},a={method:"POST",headers:i,body:JSON.stringify(s)},c=await Xo(()=>fetch(r,a));if(c.ok){const u=await c.json();return Wo(u)}else throw await Jo("Generate Auth Token",c)}function Jf(e,{fid:t}){return`${zo(e)}/${t}/authTokens:generate`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Yn(e,t=!1){let n;const r=await xt(e.appConfig,o=>{if(!rs(o))throw de.create("not-registered");const s=o.authToken;if(!t&&Yf(s))return o;if(s.requestStatus===1)return n=Gf(e,t),o;{if(!navigator.onLine)throw de.create("app-offline");const a=Qf(o);return n=Xf(e,a),a}});return n?await n:r.authToken}async function Gf(e,t){let n=await Lr(e.appConfig);for(;n.authToken.requestStatus===1;)await Yo(100),n=await Lr(e.appConfig);const r=n.authToken;return r.requestStatus===0?Yn(e,t):r}function Lr(e){return xt(e,t=>{if(!rs(t))throw de.create("not-registered");const n=t.authToken;return ed(n)?Object.assign(Object.assign({},t),{authToken:{requestStatus:0}}):t})}async function Xf(e,t){try{const n=await Wf(e,t),r=Object.assign(Object.assign({},t),{authToken:n});return await at(e.appConfig,r),n}catch(n){if(Vo(n)&&(n.customData.serverCode===401||n.customData.serverCode===404))await ts(e.appConfig);else{const r=Object.assign(Object.assign({},t),{authToken:{requestStatus:0}});await at(e.appConfig,r)}throw n}}function rs(e){return e!==void 0&&e.registrationStatus===2}function Yf(e){return e.requestStatus===2&&!Zf(e)}function Zf(e){const t=Date.now();return t<e.creationTime||e.creationTime+e.expiresIn<t+xf}function Qf(e){const t={requestStatus:1,requestTime:Date.now()};return Object.assign(Object.assign({},e),{authToken:t})}function ed(e){return e.requestStatus===1&&e.requestTime+Uo<Date.now()}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function td(e){const t=e,{installationEntry:n,registrationPromise:r}=await Xn(t);return r?r.catch(console.error):Yn(t).catch(console.error),n.fid}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function nd(e,t=!1){const n=e;return await rd(n),(await Yn(n,t)).token}async function rd(e){const{registrationPromise:t}=await Xn(e);t&&await t}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function id(e){if(!e||!e.options)throw jt("App Configuration");if(!e.name)throw jt("App Name");const t=["projectId","apiKey","appId"];for(const n of t)if(!e.options[n])throw jt(n);return{appName:e.name,projectId:e.options.projectId,apiKey:e.options.apiKey,appId:e.options.appId}}function jt(e){return de.create("missing-app-config-values",{valueName:e})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const is="installations",od="installations-internal",sd=e=>{const t=e.getProvider("app").getImmediate(),n=id(t),r=Wn(t,"heartbeat");return{app:t,appConfig:n,heartbeatServiceProvider:r,_delete:()=>Promise.resolve()}},ad=e=>{const t=e.getProvider("app").getImmediate(),n=Wn(t,is).getImmediate();return{getId:()=>td(n),getToken:i=>nd(n,i)}};function cd(){fe(new Y(is,sd,"PUBLIC")),fe(new Y(od,ad,"PRIVATE"))}cd();J(Ho,Jn);J(Ho,Jn,"esm2017");/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ud="/firebase-messaging-sw.js",ld="/firebase-cloud-messaging-push-scope",os="BDOU99-h67HcA6JeFXHbSNMu7e2yNNu3RzoMj8TM4W88jITfq7ZmPvIM1Iv-4_l2LxQcYwhqby2xGpWwzjfAnG4",fd="https://fcmregistrations.googleapis.com/v1",ss="google.c.a.c_id",dd="google.c.a.c_l",pd="google.c.a.ts",hd="google.c.a.e",jr=1e4;var Hr;(function(e){e[e.DATA_MESSAGE=1]="DATA_MESSAGE",e[e.DISPLAY_NOTIFICATION=3]="DISPLAY_NOTIFICATION"})(Hr||(Hr={}));/**
 * @license
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */var Be;(function(e){e.PUSH_RECEIVED="push-received",e.NOTIFICATION_CLICKED="notification-clicked"})(Be||(Be={}));/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function U(e){const t=new Uint8Array(e);return btoa(String.fromCharCode(...t)).replace(/=/g,"").replace(/\+/g,"-").replace(/\//g,"_")}function gd(e){const t="=".repeat((4-e.length%4)%4),n=(e+t).replace(/\-/g,"+").replace(/_/g,"/"),r=atob(n),i=new Uint8Array(r.length);for(let o=0;o<r.length;++o)i[o]=r.charCodeAt(o);return i}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ht="fcm_token_details_db",md=5,Ur="fcm_token_object_Store";async function bd(e){if("databases"in indexedDB&&!(await indexedDB.databases()).map(o=>o.name).includes(Ht))return null;let t=null;return(await vt(Ht,md,{upgrade:async(r,i,o,s)=>{var a;if(i<2||!r.objectStoreNames.contains(Ur))return;const c=s.objectStore(Ur),u=await c.index("fcmSenderId").get(e);if(await c.clear(),!!u){if(i===2){const l=u;if(!l.auth||!l.p256dh||!l.endpoint)return;t={token:l.fcmToken,createTime:(a=l.createTime)!==null&&a!==void 0?a:Date.now(),subscriptionOptions:{auth:l.auth,p256dh:l.p256dh,endpoint:l.endpoint,swScope:l.swScope,vapidKey:typeof l.vapidKey=="string"?l.vapidKey:U(l.vapidKey)}}}else if(i===3){const l=u;t={token:l.fcmToken,createTime:l.createTime,subscriptionOptions:{auth:U(l.auth),p256dh:U(l.p256dh),endpoint:l.endpoint,swScope:l.swScope,vapidKey:U(l.vapidKey)}}}else if(i===4){const l=u;t={token:l.fcmToken,createTime:l.createTime,subscriptionOptions:{auth:U(l.auth),p256dh:U(l.p256dh),endpoint:l.endpoint,swScope:l.swScope,vapidKey:U(l.vapidKey)}}}}}})).close(),await Bt(Ht),await Bt("fcm_vapid_details_db"),await Bt("undefined"),_d(t)?t:null}function _d(e){if(!e||!e.subscriptionOptions)return!1;const{subscriptionOptions:t}=e;return typeof e.createTime=="number"&&e.createTime>0&&typeof e.token=="string"&&e.token.length>0&&typeof t.auth=="string"&&t.auth.length>0&&typeof t.p256dh=="string"&&t.p256dh.length>0&&typeof t.endpoint=="string"&&t.endpoint.length>0&&typeof t.swScope=="string"&&t.swScope.length>0&&typeof t.vapidKey=="string"&&t.vapidKey.length>0}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const yd="firebase-messaging-database",wd=1,$e="firebase-messaging-store";let Ut=null;function as(){return Ut||(Ut=vt(yd,wd,{upgrade:(e,t)=>{switch(t){case 0:e.createObjectStore($e)}}})),Ut}async function Ed(e){const t=cs(e),r=await(await as()).transaction($e).objectStore($e).get(t);if(r)return r;{const i=await bd(e.appConfig.senderId);if(i)return await Zn(e,i),i}}async function Zn(e,t){const n=cs(e),i=(await as()).transaction($e,"readwrite");return await i.objectStore($e).put(t,n),await i.done,t}function cs({appConfig:e}){return e.appId}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Sd={"missing-app-config-values":'Missing App configuration value: "{$valueName}"',"only-available-in-window":"This method is available in a Window context.","only-available-in-sw":"This method is available in a service worker context.","permission-default":"The notification permission was not granted and dismissed instead.","permission-blocked":"The notification permission was not granted and blocked instead.","unsupported-browser":"This browser doesn't support the API's required to use the Firebase SDK.","indexed-db-unsupported":"This browser doesn't support indexedDb.open() (ex. Safari iFrame, Firefox Private Browsing, etc)","failed-service-worker-registration":"We are unable to register the default service worker. {$browserErrorMessage}","token-subscribe-failed":"A problem occurred while subscribing the user to FCM: {$errorInfo}","token-subscribe-no-token":"FCM returned no token when subscribing the user to push.","token-unsubscribe-failed":"A problem occurred while unsubscribing the user from FCM: {$errorInfo}","token-update-failed":"A problem occurred while updating the user from FCM: {$errorInfo}","token-update-no-token":"FCM returned no token when updating the user to push.","use-sw-after-get-token":"The useServiceWorker() method may only be called once and must be called before calling getToken() to ensure your service worker is used.","invalid-sw-registration":"The input to useServiceWorker() must be a ServiceWorkerRegistration.","invalid-bg-handler":"The input to setBackgroundMessageHandler() must be a function.","invalid-vapid-key":"The public VAPID key must be a string.","use-vapid-key-after-get-token":"The usePublicVapidKey() method may only be called once and must be called before calling getToken() to ensure your VAPID key is used."},R=new St("messaging","Messaging",Sd);/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function vd(e,t){const n=await er(e),r=us(t),i={method:"POST",headers:n,body:JSON.stringify(r)};let o;try{o=await(await fetch(Qn(e.appConfig),i)).json()}catch(s){throw R.create("token-subscribe-failed",{errorInfo:s==null?void 0:s.toString()})}if(o.error){const s=o.error.message;throw R.create("token-subscribe-failed",{errorInfo:s})}if(!o.token)throw R.create("token-subscribe-no-token");return o.token}async function Ad(e,t){const n=await er(e),r=us(t.subscriptionOptions),i={method:"PATCH",headers:n,body:JSON.stringify(r)};let o;try{o=await(await fetch(`${Qn(e.appConfig)}/${t.token}`,i)).json()}catch(s){throw R.create("token-update-failed",{errorInfo:s==null?void 0:s.toString()})}if(o.error){const s=o.error.message;throw R.create("token-update-failed",{errorInfo:s})}if(!o.token)throw R.create("token-update-no-token");return o.token}async function xd(e,t){const r={method:"DELETE",headers:await er(e)};try{const o=await(await fetch(`${Qn(e.appConfig)}/${t}`,r)).json();if(o.error){const s=o.error.message;throw R.create("token-unsubscribe-failed",{errorInfo:s})}}catch(i){throw R.create("token-unsubscribe-failed",{errorInfo:i==null?void 0:i.toString()})}}function Qn({projectId:e}){return`${fd}/projects/${e}/registrations`}async function er({appConfig:e,installations:t}){const n=await t.getToken();return new Headers({"Content-Type":"application/json",Accept:"application/json","x-goog-api-key":e.apiKey,"x-goog-firebase-installations-auth":`FIS ${n}`})}function us({p256dh:e,auth:t,endpoint:n,vapidKey:r}){const i={web:{endpoint:n,auth:t,p256dh:e}};return r!==os&&(i.web.applicationPubKey=r),i}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Td=7*24*60*60*1e3;async function Od(e){const t=await Id(e.swRegistration,e.vapidKey),n={vapidKey:e.vapidKey,swScope:e.swRegistration.scope,endpoint:t.endpoint,auth:U(t.getKey("auth")),p256dh:U(t.getKey("p256dh"))},r=await Ed(e.firebaseDependencies);if(r){if(Rd(r.subscriptionOptions,n))return Date.now()>=r.createTime+Td?Cd(e,{token:r.token,createTime:Date.now(),subscriptionOptions:n}):r.token;try{await xd(e.firebaseDependencies,r.token)}catch(i){console.warn(i)}return qr(e.firebaseDependencies,n)}else return qr(e.firebaseDependencies,n)}async function Cd(e,t){try{const n=await Ad(e.firebaseDependencies,t),r=Object.assign(Object.assign({},t),{token:n,createTime:Date.now()});return await Zn(e.firebaseDependencies,r),n}catch(n){throw n}}async function qr(e,t){const r={token:await vd(e,t),createTime:Date.now(),subscriptionOptions:t};return await Zn(e,r),r.token}async function Id(e,t){const n=await e.pushManager.getSubscription();return n||e.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:gd(t)})}function Rd(e,t){const n=t.vapidKey===e.vapidKey,r=t.endpoint===e.endpoint,i=t.auth===e.auth,o=t.p256dh===e.p256dh;return n&&r&&i&&o}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Kr(e){const t={from:e.from,collapseKey:e.collapse_key,messageId:e.fcmMessageId};return Dd(t,e),Nd(t,e),kd(t,e),t}function Dd(e,t){if(!t.notification)return;e.notification={};const n=t.notification.title;n&&(e.notification.title=n);const r=t.notification.body;r&&(e.notification.body=r);const i=t.notification.image;i&&(e.notification.image=i);const o=t.notification.icon;o&&(e.notification.icon=o)}function Nd(e,t){t.data&&(e.data=t.data)}function kd(e,t){var n,r,i,o,s;if(!t.fcmOptions&&!(!((n=t.notification)===null||n===void 0)&&n.click_action))return;e.fcmOptions={};const a=(i=(r=t.fcmOptions)===null||r===void 0?void 0:r.link)!==null&&i!==void 0?i:(o=t.notification)===null||o===void 0?void 0:o.click_action;a&&(e.fcmOptions.link=a);const c=(s=t.fcmOptions)===null||s===void 0?void 0:s.analytics_label;c&&(e.fcmOptions.analyticsLabel=c)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Pd(e){return typeof e=="object"&&!!e&&ss in e}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Md(e){if(!e||!e.options)throw qt("App Configuration Object");if(!e.name)throw qt("App Name");const t=["projectId","apiKey","appId","messagingSenderId"],{options:n}=e;for(const r of t)if(!n[r])throw qt(r);return{appName:e.name,projectId:n.projectId,apiKey:n.apiKey,appId:n.appId,senderId:n.messagingSenderId}}function qt(e){return R.create("missing-app-config-values",{valueName:e})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class Bd{constructor(t,n,r){this.deliveryMetricsExportedToBigQueryEnabled=!1,this.onBackgroundMessageHandler=null,this.onMessageHandler=null,this.logEvents=[],this.isLogServiceStarted=!1;const i=Md(t);this.firebaseDependencies={app:t,appConfig:i,installations:n,analyticsProvider:r}}_delete(){return Promise.resolve()}}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function $d(e){try{e.swRegistration=await navigator.serviceWorker.register(ud,{scope:ld}),e.swRegistration.update().catch(()=>{}),await Fd(e.swRegistration)}catch(t){throw R.create("failed-service-worker-registration",{browserErrorMessage:t==null?void 0:t.message})}}async function Fd(e){return new Promise((t,n)=>{const r=setTimeout(()=>n(new Error(`Service worker not registered after ${jr} ms`)),jr),i=e.installing||e.waiting;e.active?(clearTimeout(r),t()):i?i.onstatechange=o=>{var s;((s=o.target)===null||s===void 0?void 0:s.state)==="activated"&&(i.onstatechange=null,clearTimeout(r),t())}:(clearTimeout(r),n(new Error("No incoming service worker found.")))})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Ld(e,t){if(!t&&!e.swRegistration&&await $d(e),!(!t&&e.swRegistration)){if(!(t instanceof ServiceWorkerRegistration))throw R.create("invalid-sw-registration");e.swRegistration=t}}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function jd(e,t){t?e.vapidKey=t:e.vapidKey||(e.vapidKey=os)}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function ls(e,t){if(!navigator)throw R.create("only-available-in-window");if(Notification.permission==="default"&&await Notification.requestPermission(),Notification.permission!=="granted")throw R.create("permission-blocked");return await jd(e,t==null?void 0:t.vapidKey),await Ld(e,t==null?void 0:t.serviceWorkerRegistration),Od(e)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Hd(e,t,n){const r=Ud(t);(await e.firebaseDependencies.analyticsProvider.get()).logEvent(r,{message_id:n[ss],message_name:n[dd],message_time:n[pd],message_device_time:Math.floor(Date.now()/1e3)})}function Ud(e){switch(e){case Be.NOTIFICATION_CLICKED:return"notification_open";case Be.PUSH_RECEIVED:return"notification_foreground";default:throw new Error}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function qd(e,t){const n=t.data;if(!n.isFirebaseMessaging)return;e.onMessageHandler&&n.messageType===Be.PUSH_RECEIVED&&(typeof e.onMessageHandler=="function"?e.onMessageHandler(Kr(n)):e.onMessageHandler.next(Kr(n)));const r=n.data;Pd(r)&&r[hd]==="1"&&await Hd(e,n.messageType,r)}const Vr="@firebase/messaging",zr="0.12.17";/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Kd=e=>{const t=new Bd(e.getProvider("app").getImmediate(),e.getProvider("installations-internal").getImmediate(),e.getProvider("analytics-internal"));return navigator.serviceWorker.addEventListener("message",n=>qd(t,n)),t},Vd=e=>{const t=e.getProvider("messaging").getImmediate();return{getToken:r=>ls(t,r)}};function zd(){fe(new Y("messaging",Kd,"PUBLIC")),fe(new Y("messaging-internal",Vd,"PRIVATE")),J(Vr,zr),J(Vr,zr,"esm2017")}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Wd(){try{await Mo()}catch{return!1}return typeof window<"u"&&Po()&&ul()&&"serviceWorker"in navigator&&"PushManager"in window&&"Notification"in window&&"fetch"in window&&ServiceWorkerRegistration.prototype.hasOwnProperty("showNotification")&&PushSubscription.prototype.hasOwnProperty("getKey")}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Jd(e,t){if(!navigator)throw R.create("only-available-in-window");return e.onMessageHandler=t,()=>{e.onMessageHandler=null}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Gd(e=ff()){return Wd().then(t=>{if(!t)throw R.create("unsupported-browser")},t=>{throw R.create("indexed-db-unsupported")}),Wn(Vn(e),"messaging").getImmediate()}async function Xd(e,t){return e=Vn(e),ls(e,t)}function Yd(e,t){return e=Vn(e),Jd(e,t)}zd();window.Alpine=Io;Io.start();const ct=window.firebaseConfig;(!ct||!ct.projectId)&&console.error("Firebase configuration is missing. Check .env and app.blade.php.");const Zd=Fo(ct),fs=Gd(Zd);function Qd(){Notification.requestPermission().then(e=>{e==="granted"?(console.log("Notification permission granted."),Xd(fs,{vapidKey:ct.vapidKey}).then(t=>{t?(console.log("FCM Token:",t),ep(t)):console.log("No registration token available.")}).catch(t=>{console.error("Error retrieving token.",t)})):console.log("Notification permission denied.")})}function ep(e){fetch("/save-fcm-token",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({fcm_token:e})}).then(t=>t.json()).then(t=>console.log("Token saved:",t)).catch(t=>console.error("Error saving token:",t))}Yd(fs,e=>{console.log("Message received:",e);const t=e.notification.title,n={body:e.notification.body,icon:"/firebase-logo.png"};new Notification(t,n)});Qd();
