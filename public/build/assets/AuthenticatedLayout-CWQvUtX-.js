import{A as B}from"./ApplicationLogo-WFajWuJc.js";import{k as N,l as M,h as v,s as S,o as d,f as g,b as e,r as c,m as k,v as $,a as r,w as o,n as u,p as D,c as x,u as m,i as y,d as l,t as C,g as E}from"./app-PlneoILl.js";const j={class:"relative"},O={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:String,default:"py-1 bg-white"}},setup(n){const s=n,t=h=>{i.value&&h.key==="Escape"&&(i.value=!1)};N(()=>document.addEventListener("keydown",t)),M(()=>document.removeEventListener("keydown",t));const a=v(()=>({48:"w-48"})[s.width.toString()]),p=v(()=>s.align==="left"?"ltr:origin-top-left rtl:origin-top-right start-0":s.align==="right"?"ltr:origin-top-right rtl:origin-top-left end-0":"origin-top"),i=S(!1);return(h,f)=>(d(),g("div",j,[e("div",{onClick:f[0]||(f[0]=w=>i.value=!i.value)},[c(h.$slots,"trigger")]),k(e("div",{class:"fixed inset-0 z-40",onClick:f[1]||(f[1]=w=>i.value=!1)},null,512),[[$,i.value]]),r(D,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"opacity-0 scale-95","enter-to-class":"opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"opacity-100 scale-100","leave-to-class":"opacity-0 scale-95"},{default:o(()=>[k(e("div",{class:u(["absolute z-50 mt-2 rounded-md shadow-lg",[a.value,p.value]]),style:{display:"none"},onClick:f[2]||(f[2]=w=>i.value=!1)},[e("div",{class:u(["rounded-md ring-1 ring-black ring-opacity-5",n.contentClasses])},[c(h.$slots,"content")],2)],2),[[$,i.value]])]),_:3})]))}},_={__name:"DropdownLink",props:{href:{type:String,required:!0}},setup(n){return(s,t)=>(d(),x(m(y),{href:n.href,class:"block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},{default:o(()=>[c(s.$slots,"default")]),_:3},8,["href"]))}},L={__name:"NavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(n){const s=n,t=v(()=>s.active?"inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out":"inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out");return(a,p)=>(d(),x(m(y),{href:n.href,class:u(t.value)},{default:o(()=>[c(a.$slots,"default")]),_:3},8,["href","class"]))}},b={__name:"ResponsiveNavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(n){const s=n,t=v(()=>s.active?"block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out":"block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out");return(a,p)=>(d(),x(m(y),{href:n.href,class:u(t.value)},{default:o(()=>[c(a.$slots,"default")]),_:3},8,["href","class"]))}},V={class:"min-h-screen bg-gray-100"},q={class:"bg-white border-b border-gray-100"},z={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},A={class:"flex justify-between h-16"},R={class:"flex"},T={class:"shrink-0 flex items-center"},P={class:"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"},U={class:"hidden sm:flex sm:items-center sm:ms-6"},F={class:"ms-3 relative"},G={class:"inline-flex rounded-md"},H={class:"-me-2 flex items-center sm:hidden"},I={class:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},J={class:"pt-2 pb-3 space-y-1"},K={class:"pt-4 pb-1 border-t border-gray-200"},Q={class:"px-4"},W={class:"font-medium text-base text-gray-800"},X={class:"font-medium text-sm text-gray-500"},Y={class:"mt-3 space-y-1"},Z={key:0,class:"bg-white shadow"},ee={class:"max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"},oe={__name:"AuthenticatedLayout",setup(n){const s=S(!1);return(t,a)=>(d(),g("div",null,[e("div",V,[e("nav",q,[e("div",z,[e("div",A,[e("div",R,[e("div",T,[r(m(y),{href:t.route("reports")},{default:o(()=>[r(B,{class:"block h-9 w-auto fill-current text-gray-800"})]),_:1},8,["href"])]),e("div",P,[r(L,{href:t.route("reports"),active:t.route().current("reports")},{default:o(()=>[l(" Reports ")]),_:1},8,["href","active"]),r(L,{href:t.route("transactions"),active:t.route().current("transactions")},{default:o(()=>[l(" Transactions ")]),_:1},8,["href","active"])])]),e("div",U,[e("div",F,[r(O,{align:"right",width:"48"},{trigger:o(()=>[e("span",G,[r(_,{href:t.route("logout"),method:"post",as:"button"},{default:o(()=>[l(" Log Out ")]),_:1},8,["href"])])]),content:o(()=>[r(_,{href:t.route("profile.edit")},{default:o(()=>[l(" Profile ")]),_:1},8,["href"]),r(_,{href:t.route("logout"),method:"post",as:"button"},{default:o(()=>[l(" Log Out ")]),_:1},8,["href"])]),_:1})])]),e("div",H,[e("button",{onClick:a[0]||(a[0]=p=>s.value=!s.value),class:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"},[(d(),g("svg",I,[e("path",{class:u({hidden:s.value,"inline-flex":!s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h16M4 18h16"},null,2),e("path",{class:u({hidden:!s.value,"inline-flex":s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"},null,2)]))])])])]),e("div",{class:u([{block:s.value,hidden:!s.value},"sm:hidden"])},[e("div",J,[r(b,{href:t.route("reports"),active:t.route().current("reports")},{default:o(()=>[l(" Reports ")]),_:1},8,["href","active"])]),e("div",K,[e("div",Q,[e("div",W,C(t.$page.props.auth.user.name),1),e("div",X,C(t.$page.props.auth.user.email),1)]),e("div",Y,[r(b,{href:t.route("profile.edit")},{default:o(()=>[l(" Profile ")]),_:1},8,["href"]),r(b,{href:t.route("logout"),method:"post",as:"button"},{default:o(()=>[l(" Log Out ")]),_:1},8,["href"])])])],2)]),t.$slots.header?(d(),g("header",Z,[e("div",ee,[c(t.$slots,"header")])])):E("",!0),e("main",null,[c(t.$slots,"default")])])]))}};export{oe as _};