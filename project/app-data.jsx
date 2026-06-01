// app-data.jsx — Shared sample data, icons and hooks for the vakantieplanner prototype.

// ─── Sample trip data ────────────────────────────────────────────────
const SAMPLE_TRIPS = [
  {
    id: "lis",
    title: "Lissabon",
    subtitle: "Met de groep",
    country: "Portugal",
    dates: "12 — 19 juli 2026",
    daysAway: 45,
    cover: "linear-gradient(135deg,#a87f5e 0%,#5b3b25 60%,#241612 100%)",
    members: [
      { id: "sara", name: "Sara de Wit", initials: "SW", role: "Eigenaar", hue: 28 },
      { id: "tom",  name: "Tom Bakker",   initials: "TB", role: "Bewerker", hue: 200 },
      { id: "nik",  name: "Niki Janssen", initials: "NJ", role: "Bewerker", hue: 145 },
      { id: "ver",  name: "Vera Smit",    initials: "VS", role: "Kijker",   hue: 340 },
    ],
    nights: 7,
    budget: 1240,
    spent: 612,
    days: [
      {
        date: "Zo 12 jul", label: "Aankomst", weather: "29°",
        items: [
          { t: "14:20", title: "Vlucht KL1693 · AMS → LIS", kind: "flight", by: "tom" },
          { t: "16:40", title: "Taxi naar Alfama", kind: "transit", by: "sara" },
          { t: "19:00", title: "Diner — Taberna da Rua das Flores", kind: "food", by: "niki", liked: ["sara","tom"] },
        ],
      },
      {
        date: "Ma 13 jul", label: "Stad verkennen", weather: "31°",
        items: [
          { t: "10:00", title: "Tram 28 vanaf Martim Moniz", kind: "transit", by: "sara" },
          { t: "12:30", title: "LX Factory — lunch & shoppen", kind: "place", by: "vera" },
          { t: "16:00", title: "Castelo de São Jorge", kind: "place", by: "tom", liked: ["sara","niki","vera"] },
          { t: "21:00", title: "Fado in Bairro Alto", kind: "place", by: "niki" },
        ],
      },
      {
        date: "Di 14 jul", label: "Sintra dagtrip", weather: "27°",
        items: [
          { t: "09:00", title: "Trein naar Sintra", kind: "transit", by: "tom" },
          { t: "11:00", title: "Palácio da Pena", kind: "place", by: "sara", liked: ["tom","niki"] },
          { t: "15:00", title: "Quinta da Regaleira", kind: "place", by: "niki" },
        ],
      },
      {
        date: "Wo 15 jul", label: "Strand Cascais", weather: "26°",
        items: [
          { t: "10:30", title: "Trein Cais do Sodré → Cascais", kind: "transit", by: "vera" },
          { t: "12:00", title: "Praia da Rainha", kind: "place", by: "sara" },
          { t: "20:00", title: "Diner Marisco na Praça", kind: "food", by: "tom" },
        ],
      },
    ],
    packing: [
      { id: "p1", text: "Paspoort", who: "sara", done: true,  cat: "Documenten" },
      { id: "p2", text: "Reisverzekering printen", who: "sara", done: true, cat: "Documenten" },
      { id: "p3", text: "Zonnebrand SPF 50", who: "niki", done: false, cat: "Verzorging" },
      { id: "p4", text: "Adapter EU", who: "tom", done: false, cat: "Elektronica" },
      { id: "p5", text: "Zwemkleding", who: "vera", done: true, cat: "Kleding" },
      { id: "p6", text: "Wandelschoenen", who: "tom", done: false, cat: "Kleding" },
      { id: "p7", text: "Kaartspel", who: "niki", done: false, cat: "Overig" },
      { id: "p8", text: "Oplader telefoon", who: "vera", done: false, cat: "Elektronica" },
    ],
    shopping: [
      { id: "s1", text: "Water (6 flessen)", done: false },
      { id: "s2", text: "Fruit voor onderweg", done: false },
      { id: "s3", text: "Snacks vlucht", done: true },
      { id: "s4", text: "Tandpasta reisformaat", done: false },
    ],
    places: [
      { id: "r1", name: "Taberna da Rua das Flores", kind: "Restaurant", note: "Geen reservering, vroeg gaan", liked: 3 },
      { id: "r2", name: "Time Out Market", kind: "Markt", note: "Lunch — proeven van alles", liked: 4 },
      { id: "r3", name: "Pastéis de Belém", kind: "Bakkerij", note: "Originele pastéis", liked: 4 },
      { id: "r4", name: "Park bar Lost In", kind: "Bar", note: "Uitzicht op de heuvels", liked: 2 },
      { id: "r5", name: "Cervejaria Ramiro", kind: "Restaurant", note: "Schaaldieren, druk", liked: 3 },
    ],
    bookings: [
      { id: "b1", type: "Vlucht heen", title: "KL1693 · AMS → LIS", date: "12 jul · 11:55", code: "X8K2P9", cost: 184, by: "tom" },
      { id: "b2", type: "Appartement", title: "Casa Alfama (2 slaapk.)", date: "12 — 19 jul", code: "AIRB-44218", cost: 720, by: "sara" },
      { id: "b3", type: "Auto Sintra", title: "Renault Clio", date: "14 jul · 08:00", code: "EUR-91032", cost: 64, by: "niki" },
      { id: "b4", type: "Vlucht terug", title: "TP662 · LIS → AMS", date: "19 jul · 13:10", code: "Q1L7N3", cost: 192, by: "tom" },
    ],
    budget_items: [
      { id: "e1", title: "Appartement", who: "sara", amount: 720, split: "alle" },
      { id: "e2", title: "Vluchten heen", who: "tom", amount: 736, split: "alle" },
      { id: "e3", title: "Boodschappen aankomst", who: "niki", amount: 38, split: "alle" },
      { id: "e4", title: "Diner Taberna", who: "vera", amount: 92, split: "alle" },
    ],
  },
  {
    id: "txl",
    title: "Texel — long weekend",
    subtitle: "Met Tom",
    country: "Nederland",
    dates: "2 — 5 oktober 2026",
    daysAway: 127,
    cover: "linear-gradient(135deg,#cfd6c7 0%,#7c8770 60%,#2f3a30 100%)",
    members: [
      { id: "sara", name: "Sara de Wit", initials: "SW", role: "Eigenaar", hue: 28 },
      { id: "tom",  name: "Tom Bakker",  initials: "TB", role: "Bewerker", hue: 200 },
    ],
    nights: 3,
  },
  {
    id: "tok",
    title: "Tokyo & Kyoto",
    subtitle: "Idee — nog niet geboekt",
    country: "Japan",
    dates: "Maart 2027 · 16 dagen",
    daysAway: 280,
    cover: "linear-gradient(135deg,#e9c5c0 0%,#8a3a3a 60%,#2a0d0d 100%)",
    members: [
      { id: "sara", name: "Sara de Wit", initials: "SW", role: "Eigenaar", hue: 28 },
      { id: "nik",  name: "Niki Janssen", initials: "NJ", role: "Bewerker", hue: 145 },
    ],
    nights: 15,
  },
];

// ─── Icons (line, neutral, no emoji) ─────────────────────────────────
const Ic = {
  plane: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><path d="M10.5 3.5 11 11 3 14v2l8-1.5L11 21l2 .5.5-6L21 14v-2l-7.5-3 .5-7.5Z"/></svg>,
  pin: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><path d="M12 21s7-7.5 7-13a7 7 0 1 0-14 0c0 5.5 7 13 7 13Z"/><circle cx="12" cy="8" r="2.5"/></svg>,
  fork: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><path d="M5 3v6a2 2 0 0 0 2 2h0a2 2 0 0 0 2-2V3M7 11v10M16 3v6c0 1 .5 2 1.5 2.5L19 12v9"/></svg>,
  bus: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><rect x="5" y="4" width="14" height="14" rx="2"/><path d="M5 11h14M8 18v2M16 18v2"/><circle cx="9" cy="15" r=".7" fill="currentColor"/><circle cx="15" cy="15" r=".7" fill="currentColor"/></svg>,
  check: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="m4 12 5 5L20 6"/></svg>,
  plus: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round"><path d="M12 5v14M5 12h14"/></svg>,
  back: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M15 5 8 12l7 7"/></svg>,
  more: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="5" cy="12" r="1.2" fill="currentColor"/><circle cx="12" cy="12" r="1.2" fill="currentColor"/><circle cx="19" cy="12" r="1.2" fill="currentColor"/></svg>,
  search: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.5-4.5"/></svg>,
  cal: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 9.5h17M8 3v4M16 3v4"/></svg>,
  map: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><path d="m3 6 6-2 6 2 6-2v14l-6 2-6-2-6 2V6Z"/><path d="M9 4v16M15 6v16"/></svg>,
  list: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><path d="M8 6h13M8 12h13M8 18h13"/><circle cx="4" cy="6" r="1.2" fill="currentColor"/><circle cx="4" cy="12" r="1.2" fill="currentColor"/><circle cx="4" cy="18" r="1.2" fill="currentColor"/></svg>,
  euro: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><path d="M18 6.5A7 7 0 1 0 18 18M4 10h10M4 14h10"/></svg>,
  user: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4.5-6 8-6s7 2 8 6"/></svg>,
  share: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="6" r="2.5"/><circle cx="18" cy="18" r="2.5"/><path d="m8 11 8-4M8 13l8 4"/></svg>,
  bell: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><path d="M6 16V11a6 6 0 1 1 12 0v5l1.5 2.5h-15L6 16Z"/><path d="M10 20a2 2 0 0 0 4 0"/></svg>,
  arrow: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="none" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>,
  star: (p)=> <svg viewBox="0 0 24 24" width={p?.s||18} height={p?.s||18} fill="currentColor"><path d="m12 3 2.7 5.7 6.3.8-4.6 4.3 1.2 6.2L12 17l-5.6 3 1.2-6.2L3 9.5l6.3-.8L12 3Z"/></svg>,
};

function kindIcon(k){
  if (k==="flight") return Ic.plane();
  if (k==="food")   return Ic.fork();
  if (k==="transit")return Ic.bus();
  return Ic.pin();
}

// ─── Avatar ───────────────────────────────────────────────────────────
function Avatar({m, size=28, ring}){
  const bg = `oklch(0.78 0.06 ${m.hue})`;
  const fg = `oklch(0.28 0.06 ${m.hue})`;
  return (
    <div style={{
      width:size, height:size, borderRadius:999, background:bg, color:fg,
      display:"flex", alignItems:"center", justifyContent:"center",
      fontFamily:"var(--vp-body)", fontSize:Math.round(size*0.38), fontWeight:600, letterSpacing:0.3,
      boxShadow: ring ? `0 0 0 2px ${ring}` : "none", flexShrink:0,
    }}>{m.initials}</div>
  );
}
function AvatarStack({members, size=24, max=4}){
  const shown = members.slice(0, max);
  const overlap = Math.round(size*0.35);
  return (
    <div style={{display:"flex"}}>
      {shown.map((m,i)=>(
        <div key={m.id} style={{marginLeft: i===0?0:-overlap}}>
          <Avatar m={m} size={size} ring="var(--vp-bg)"/>
        </div>
      ))}
      {members.length>max && (
        <div style={{
          width:size, height:size, marginLeft:-overlap, borderRadius:999,
          background:"var(--vp-bg-sub)", color:"var(--vp-fg)",
          display:"flex", alignItems:"center", justifyContent:"center",
          fontFamily:"var(--vp-body)", fontSize:Math.round(size*0.38), fontWeight:600,
          boxShadow:"0 0 0 2px var(--vp-bg)",
        }}>+{members.length-max}</div>
      )}
    </div>
  );
}

// ─── Tiny placeholder "map" rendering ─────────────────────────────────
function MiniMap({pins=5, dark=false, height=160, label="Lissabon"}){
  const land = dark ? "#1a1a1a" : "#ece8df";
  const water = dark ? "#0e1418" : "#d9e3e8";
  const roads = dark ? "rgba(255,255,255,.07)" : "rgba(0,0,0,.06)";
  const pinFill = "var(--vp-accent)";
  // deterministic pseudo-pins
  const pts = Array.from({length:pins}, (_,i)=>{
    const x = ((i*73+19)%82)+9; const y = ((i*131+11)%62)+18;
    return {x,y};
  });
  return (
    <div style={{
      position:"relative", width:"100%", height, borderRadius:"var(--vp-radius)",
      overflow:"hidden", background:land, border:"1px solid var(--vp-line)",
    }}>
      {/* water river */}
      <div style={{position:"absolute", left:0, right:0, bottom:0, height:"38%", background:water,
        clipPath:"polygon(0 30%, 18% 18%, 32% 22%, 50% 12%, 68% 18%, 84% 10%, 100% 22%, 100% 100%, 0 100%)"}}/>
      {/* road grid */}
      <svg width="100%" height="100%" style={{position:"absolute", inset:0}}>
        {[15,32,55,72].map(y=> <line key={"h"+y} x1="0" y1={y+"%"} x2="100%" y2={y+"%"} stroke={roads} strokeWidth="1"/>)}
        {[14,28,46,62,80].map(x=> <line key={"v"+x} x1={x+"%"} y1="0" x2={x+"%"} y2="100%" stroke={roads} strokeWidth="1"/>)}
      </svg>
      {/* pins */}
      {pts.map((p,i)=>(
        <div key={i} style={{position:"absolute", left:p.x+"%", top:p.y+"%", transform:"translate(-50%,-100%)"}}>
          <svg width="22" height="28" viewBox="0 0 22 28">
            <path d="M11 1c5.5 0 10 4.3 10 9.8 0 7-10 16.2-10 16.2S1 17.8 1 10.8C1 5.3 5.5 1 11 1Z" fill={pinFill} stroke="var(--vp-bg)" strokeWidth="1.5"/>
            <circle cx="11" cy="10.5" r="3.2" fill="var(--vp-bg)"/>
          </svg>
        </div>
      ))}
      {/* label */}
      <div style={{position:"absolute", left:10, top:10, padding:"4px 8px",
        background:"var(--vp-bg)", border:"1px solid var(--vp-line)", borderRadius:6,
        fontFamily:"var(--vp-body)", fontSize:10, letterSpacing:1.5, textTransform:"uppercase",
        color:"var(--vp-fg-mut)"}}>{label}</div>
    </div>
  );
}

// Expose
Object.assign(window, { SAMPLE_TRIPS, Ic, kindIcon, Avatar, AvatarStack, MiniMap });
