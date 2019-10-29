!function(n){var e={};function i(t){if(e[t])return e[t].exports;var o=e[t]={i:t,l:!1,exports:{}};return n[t].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=n,i.c=e,i.d=function(n,e,t){i.o(n,e)||Object.defineProperty(n,e,{configurable:!1,enumerable:!0,get:t})},i.n=function(n){var e=n&&n.__esModule?function(){return n.default}:function(){return n};return i.d(e,"a",e),e},i.o=function(n,e){return Object.prototype.hasOwnProperty.call(n,e)},i.p="/",i(i.s=1)}({1:function(n,e,i){n.exports=i("F1kH")},F1kH:function(n,e,i){i("SBKb"),window.getCsrf=function(){return $("meta[name=csrf-token]").attr("content")},$(document).on("click",'[data-toggle="lightbox"]',function(n){n.preventDefault(),$(this).ekkoLightbox()});var t={info:function(n,e,i){return this.notify("info",n,e,"icon-info-sign",i)},warning:function(n,e,i){return this.notify("warning",n,e,"icon-warning-sign",i)},error:function(n,e,i){return this.notify("error",n,e,"icon-minus-sign",i)},success:function(n,e,i){return this.notify("success",n,e,"icon-ok-sign",i)},notify:function(n){var e,i,o,a,s,l,d=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",r=arguments[2],c=arguments[3],h=arguments[4];function u(){e.removeClass("alert-open"),e.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",function(){return e.remove()})}return void 0===h&&(h={}),h=$.extend({},t.defaults,h),l||0===(l=$("#alerts")).length&&(l=$("<ul>").attr("id","alerts").appendTo($("body"))),h.width&&l.css({width:h.width}),e=$("<li>").addClass("alert").addClass("alert-"+n),setTimeout(function(){e.addClass("alert-open")},1),c&&(a=$("<i>").addClass(c),e.append(a)),s=$("<div>").addClass("alert-block"),e.append(s),r&&(o=$("<div>").addClass("alert-title").append(r),s.append(o)),d&&(i=$("<div>").addClass("alert-message").append(d),s.append(i)),h.displayDuration>0?setTimeout(function(){u()},h.displayDuration):s.append("<em>Click to Dismiss</em>"),e.on("click",function(){u()}),l.prepend(e)},defaults:{width:"",icon:"",displayDuration:7500,pos:""}};["info","error","success","warning"].forEach(function(n){var e=$("#alert-"+n);e.length&&t.notify(n,e.html(),e.data("title")+"!")}),$(document).ready(function(n){s(),n(window).resize(function(){s()}),n("#sidebar-logo-toggle").on("click",function(){setTimeout(function(){var e=n("#sidebar-scroll").width();n("#page-container").hasClass("sidebar-visible-xs")?(n("#mini-logo").css({display:"inline-block"}),n("#mini-logo-width").css({display:"inline-block",width:e-30+"px"}),n("#nav-mobile-logo").hide()):(n("#mini-logo").hide(),n("#nav-mobile-logo").show())},50)}),n(window).width()<767&&n("#page-content").on("click",function(){var e=n("#page-container");e.hasClass("sidebar-visible-xs")&&e.removeClass("sidebar-visible-xs")})});var o,a=767;function s(){$(window).width()<a?($("#rightSideTopDropdown").hide(),$("#user-locale-desktop").hide(),$("#user-locale").show(),$("#copyright").hide(),$("#mobile-sidebar-user-section").show(),$("#mobile-logout-option").show(),$("#mobile-settings-nav").show(),$("#desktop-settings-nav").hide(),$("#nav-mobile-logo").show(),$("#sidebar-extra-info").hide()):($("#mini-logo").hide(),$("#mobile-sidebar-user-section").hide(),$("#mobile-logout-option").hide(),$("#mobile-settings-nav").hide(),$("#user-locale").hide(),$("#rightSideTopDropdown").show(),$("#user-locale-desktop").show(),$("#copyright").show(),$("#desktop-settings-nav").show(),$("#nav-mobile-logo").hide(),$("#sidebar-extra-info").show())}o=new Set,addEventListener("beforeinput",function(n){var e=n.target;"defaultValue"in e||"defaultValue"in e.dataset||(e.dataset.defaultValue=(""+(e.value||e.textContent)).trim())}),addEventListener("input",function(n){var e=n.target;("defaultValue"in e?e.defaultValue:e.dataset.defaultValue)!==(""+(e.value||e.textContent)).trim()?o.has(e)||o.add(e):o.has(e)&&o.delete(e)}),$("form").submit(function(){window.isSubmitting=!0}),addEventListener("beforeunload",function(n){if(!window.isSubmitting&&o.size)return n.returnValue="You have some unsaved changes","You have some unsaved changes"})},SBKb:function(n,e){window.UiTables={init:function(){var n=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};App.datatables();var e={pageLength:10,processing:!0,lengthMenu:[[10,25,50,100],[10,25,50,100]],language:{searchPlaceholder:"en"===envLang?"Search...":"Suchen...",sEmptyTable:"en"===envLang?"No Data Available":"Keine Daten vorhanden",sInfo:"en"===envLang?"Showing _START_ to _END_ of _TOTAL_ entries":"_START_ bis _END_ von _TOTAL_ Einträgen",sInfoEmpty:"en"===envLang?"Showing 0 to 0 of 0 entries":"Zeige 0 bis 0 von 0 Einträgen",sLoadingRecords:'<div class="loader">\n                    <svg width="200px" height="200px">\n                        <g id="document">\n                            <path fill="#EFEADE" d="M120,87.068L108,75H80v50h40V87.068z M120,87.068"/>\n                            <path fill="#D6D1BC"\n                                  d="M90.741,99.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 C90.333,98,90,98.334,90,98.753C90,99.166,90.333,99.5,90.741,99.5L90.741,99.5z M90.741,99.5"/>\n                            <path fill="#D6D1BC"\n                                  d="M91.001,93.5h9.998c0.552,0,1.001-0.335,1.001-0.75c0-0.413-0.449-0.75-1.001-0.75h-9.998 C90.45,92,90,92.337,90,92.75C90,93.165,90.45,93.5,91.001,93.5L91.001,93.5z M91.001,93.5"/>\n                            <path fill="#D6D1BC" d="M108,75v12h12L108,75z M108,75"/>\n                            <path fill="#D6D1BC"\n                                  d="M90.741,105.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,105.166,90.333,105.5,90.741,105.5L90.741,105.5z M90.741,105.5"/>\n                            <path fill="#D6D1BC"\n                                  d="M90.741,111.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,111.166,90.333,111.5,90.741,111.5L90.741,111.5z M90.741,111.5"/>\n                            <path fill="#D6D1BC"\n                                  d="M90.741,117.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,117.166,90.333,117.5,90.741,117.5L90.741,117.5z M90.741,117.5"/>\n                        </g>\n                        <g id="search">\n                            <path fill="#566181"\n                                  d="M127.039,127.787l-13.217-13.213c2.793-2.594,4.555-6.285,4.555-10.385c0-7.821-6.367-14.189-14.188-14.189 C96.37,90,90,96.369,90,104.189c0,7.82,6.37,14.188,14.189,14.188c2.783,0,5.375-0.818,7.57-2.211l13.449,13.451 c0.26,0.246,0.582,0.383,0.924,0.383c0.32,0,0.646-0.137,0.906-0.383C127.545,129.111,127.545,128.291,127.039,127.787z M92.582,104.189c0-6.396,5.211-11.608,11.608-11.608c6.406,0,11.607,5.211,11.607,11.608c0,6.402-5.201,11.607-11.607,11.607 C97.793,115.797,92.582,110.592,92.582,104.189z"/>\n                        </g>\n                    </svg>\n                </div>',sProcessing:'<div class="loader">\n                    <svg width="200px" height="200px">\n                        <g id="document">\n                            <path fill="#EFEADE" d="M120,87.068L108,75H80v50h40V87.068z M120,87.068"/>\n                            <path fill="#D6D1BC"\n                                  d="M90.741,99.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 C90.333,98,90,98.334,90,98.753C90,99.166,90.333,99.5,90.741,99.5L90.741,99.5z M90.741,99.5"/>\n                            <path fill="#D6D1BC"\n                                  d="M91.001,93.5h9.998c0.552,0,1.001-0.335,1.001-0.75c0-0.413-0.449-0.75-1.001-0.75h-9.998 C90.45,92,90,92.337,90,92.75C90,93.165,90.45,93.5,91.001,93.5L91.001,93.5z M91.001,93.5"/>\n                            <path fill="#D6D1BC" d="M108,75v12h12L108,75z M108,75"/>\n                            <path fill="#D6D1BC"\n                                  d="M90.741,105.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,105.166,90.333,105.5,90.741,105.5L90.741,105.5z M90.741,105.5"/>\n                            <path fill="#D6D1BC"\n                                  d="M90.741,111.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,111.166,90.333,111.5,90.741,111.5L90.741,111.5z M90.741,111.5"/>\n                            <path fill="#D6D1BC"\n                                  d="M90.741,117.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,117.166,90.333,117.5,90.741,117.5L90.741,117.5z M90.741,117.5"/>\n                        </g>\n                        <g id="search">\n                            <path fill="#566181"\n                                  d="M127.039,127.787l-13.217-13.213c2.793-2.594,4.555-6.285,4.555-10.385c0-7.821-6.367-14.189-14.188-14.189 C96.37,90,90,96.369,90,104.189c0,7.82,6.37,14.188,14.189,14.188c2.783,0,5.375-0.818,7.57-2.211l13.449,13.451 c0.26,0.246,0.582,0.383,0.924,0.383c0.32,0,0.646-0.137,0.906-0.383C127.545,129.111,127.545,128.291,127.039,127.787z M92.582,104.189c0-6.396,5.211-11.608,11.608-11.608c6.406,0,11.607,5.211,11.607,11.608c0,6.402-5.201,11.607-11.607,11.607 C97.793,115.797,92.582,110.592,92.582,104.189z"/>\n                        </g>\n                    </svg>\n                </div>',sInfoFiltered:"en"===envLang?" (filtered from _MAX_ total entries) ":"(Gefiltert aus insgesamt _MAX_ Einträgen) "}};Object.assign(e,n),$(".datatable").dataTable(e)}}}});