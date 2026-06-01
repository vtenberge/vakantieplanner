// app-web.jsx — Web screens for the vakantieplanner prototype.
// Renders inside a ChromeWindow. Same shared state as mobile but laid out for desktop.

const { useState: useStateW } = React;

function WebApp({ trip, members, packing, togglePack, addPack, screen, setScreen, tab, setTab, signed, signIn, signOut, invite, setInvite, addPlace, addToBudget }) {
  if (!signed) return <WebLogin signIn={signIn}/>;
  if (screen === "trips") return <WebTripList setScreen={setScreen} signOut={signOut}/>;
  return <WebTripDetail trip={trip} members={members} packing={packing} togglePack={togglePack} addPack={addPack}
    tab={tab} setTab={setTab} setScreen={setScreen} signOut={signOut} invite={invite} setInvite={setInvite}
    addPlace={addPlace} addToBudget={addToBudget}/>;
}

// ─── Login ──────────────────────────────────────────────────────────
function WebLogin({ signIn }){
  return (
    <div style={{height:"100%", display:"grid", gridTemplateColumns:"1fr 1.1fr", background:"var(--vp-bg)", color:"var(--vp-fg)", fontFamily:"var(--vp-body)"}}>
      <div style={{padding:"60px 70px", display:"flex", flexDirection:"column", justifyContent:"space-between"}}>
        <div style={{fontSize:11, letterSpacing:2.5, textTransform:"uppercase", color:"var(--vp-fg-mut)", display:"flex", justifyContent:"space-between"}}>
          <span>Vakantieplanner</span><span>Editie 2026</span>
        </div>
        <div>
          <h1 style={{
            fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
            fontSize:88, lineHeight:0.92, letterSpacing:"var(--vp-display-tracking)", margin:"0 0 18px",
          }}>Plan samen,<br/><em style={{fontStyle:"italic", color:"var(--vp-accent)"}}>reis lichter.</em></h1>
          <p style={{fontSize:16, lineHeight:1.55, maxWidth:430, color:"var(--vp-fg-sub)", margin:"0 0 36px"}}>
            Eén plek voor paklijsten, boekingen, plekken en het budget. Voor jou en je reisgenoten — synchroon op mobiel en web.
          </p>
          <div style={{display:"flex", gap:14, alignItems:"center"}}>
            <button onClick={signIn} style={{
              padding:"14px 28px", border:"none", background:"var(--vp-fg)", color:"var(--vp-bg)",
              fontSize:14, fontWeight:600, borderRadius:"var(--vp-radius)", cursor:"pointer",
              display:"flex", alignItems:"center", gap:8,
            }}>Inloggen <Ic.arrow s={14}/></button>
            <button onClick={signIn} style={{
              padding:"14px 24px", border:"1px solid var(--vp-line)", background:"transparent", color:"var(--vp-fg)",
              fontSize:14, fontWeight:500, borderRadius:"var(--vp-radius)", cursor:"pointer",
            }}>Account aanmaken</button>
          </div>
        </div>
        <div style={{fontSize:11, color:"var(--vp-fg-mut)", display:"flex", gap:20}}>
          <span>Werkt op web, iOS &amp; Android</span>
          <span>End-to-end versleuteld</span>
        </div>
      </div>
      <div style={{
        background: SAMPLE_TRIPS[0].cover, position:"relative", overflow:"hidden",
      }}>
        <div style={{position:"absolute", inset:0, background:"linear-gradient(160deg, rgba(0,0,0,.2) 0%, rgba(0,0,0,.6) 100%)"}}/>
        {/* fake ticket-like overlay */}
        <div style={{
          position:"absolute", left:"50%", top:"50%", transform:"translate(-50%,-50%) rotate(-4deg)",
          width:380, padding:"24px 26px", background:"var(--vp-bg)", color:"var(--vp-fg)",
          border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius-lg)",
          boxShadow:"0 30px 60px rgba(0,0,0,.35)",
        }}>
          <div style={{fontSize:10, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", display:"flex", justifyContent:"space-between"}}>
            <span>Boarding pass</span><span>KL 1693</span>
          </div>
          <div style={{
            fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
            fontSize:42, lineHeight:1, margin:"10px 0 4px",
          }}>AMS → LIS</div>
          <div style={{fontSize:12, color:"var(--vp-fg-mut)", marginBottom:18}}>12 jul 2026 · 11:55 · Gate D7</div>
          <div style={{display:"flex", justifyContent:"space-between", borderTop:"1px dashed var(--vp-line-strong)", paddingTop:14}}>
            <div><div style={{fontSize:10, color:"var(--vp-fg-mut)", textTransform:"uppercase", letterSpacing:1.4}}>Reiziger</div><div style={{fontSize:14, fontWeight:600}}>S. de Wit</div></div>
            <div><div style={{fontSize:10, color:"var(--vp-fg-mut)", textTransform:"uppercase", letterSpacing:1.4}}>Stoel</div><div style={{fontSize:14, fontWeight:600}}>14A</div></div>
            <div><div style={{fontSize:10, color:"var(--vp-fg-mut)", textTransform:"uppercase", letterSpacing:1.4}}>Groep</div><div style={{fontSize:14, fontWeight:600}}>4</div></div>
          </div>
        </div>
      </div>
    </div>
  );
}

// ─── Trip List ──────────────────────────────────────────────────────
function WebTripList({ setScreen, signOut }){
  return (
    <div style={{height:"100%", display:"grid", gridTemplateColumns:"260px 1fr", background:"var(--vp-bg)", color:"var(--vp-fg)", fontFamily:"var(--vp-body)"}}>
      <WebSidebar active="trips" signOut={signOut}/>
      <div style={{padding:"30px 40px 40px", overflow:"auto"}}>
        <div style={{display:"flex", alignItems:"flex-end", justifyContent:"space-between", marginBottom:30}}>
          <div>
            <div style={{fontSize:11, letterSpacing:2.5, textTransform:"uppercase", color:"var(--vp-fg-mut)"}}>3 reizen</div>
            <h1 style={{
              fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
              fontSize:52, lineHeight:1, margin:"6px 0 0", letterSpacing:"var(--vp-display-tracking)",
            }}>Mijn reizen</h1>
          </div>
          <button style={{
            padding:"12px 18px", background:"var(--vp-fg)", color:"var(--vp-bg)", border:"none",
            borderRadius:"var(--vp-radius)", cursor:"pointer", fontSize:14, fontWeight:600,
            display:"flex", alignItems:"center", gap:8,
          }}><Ic.plus s={14}/> Nieuwe reis</button>
        </div>

        <div style={{display:"flex", gap:8, marginBottom:24}}>
          {["Aankomend","Ideeën","Afgelopen","Alle"].map((t,i)=>(
            <span key={t} style={{
              fontSize:13, fontWeight:500, padding:"7px 14px", borderRadius:999,
              background: i===0 ? "var(--vp-fg)" : "transparent",
              color: i===0 ? "var(--vp-bg)" : "var(--vp-fg-sub)",
              border: i===0 ? "none" : "1px solid var(--vp-line)",
              cursor:"pointer",
            }}>{t}</span>
          ))}
        </div>

        <div style={{display:"grid", gridTemplateColumns:"repeat(3, 1fr)", gap:18}}>
          {SAMPLE_TRIPS.map((t,i)=>(
            <button key={t.id} onClick={()=>i===0 && setScreen("detail")} style={{
              textAlign:"left", border:"1px solid var(--vp-line)",
              background:"var(--vp-bg)", padding:0,
              cursor: i===0 ? "pointer":"default",
              borderRadius:"var(--vp-radius-lg)", overflow:"hidden",
            }}>
              <div style={{height:160, background:t.cover, position:"relative"}}>
                <div style={{position:"absolute", inset:0, background:"linear-gradient(180deg, transparent 30%, rgba(0,0,0,.4) 100%)"}}/>
                <div style={{position:"absolute", left:16, top:14, color:"#fff", fontSize:10, letterSpacing:2, textTransform:"uppercase", opacity:.85}}>
                  {t.country}
                </div>
                <div style={{position:"absolute", left:16, bottom:14, color:"#fff",
                  fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)",
                  fontSize:30, lineHeight:1, fontStyle:"var(--vp-display-style)"}}>
                  {t.title}
                </div>
              </div>
              <div style={{padding:"14px 16px"}}>
                <div style={{display:"flex", justifyContent:"space-between", alignItems:"flex-start", marginBottom:10}}>
                  <div>
                    <div style={{fontSize:13, fontWeight:600}}>{t.dates}</div>
                    <div style={{fontSize:12, color:"var(--vp-fg-mut)", marginTop:2}}>{t.nights} nachten · {t.subtitle}</div>
                  </div>
                  <div style={{fontSize:11, color:"var(--vp-fg-mut)", textAlign:"right", lineHeight:1.1}}>
                    nog<br/><span style={{fontFamily:"var(--vp-display)", fontSize:22, color:"var(--vp-fg)"}}>{t.daysAway}</span><br/>dagen
                  </div>
                </div>
                <div style={{display:"flex", justifyContent:"space-between", alignItems:"center", paddingTop:10, borderTop:"1px solid var(--vp-line)"}}>
                  <AvatarStack members={t.members} size={22} max={5}/>
                  <div style={{fontSize:11, color:"var(--vp-fg-mut)"}}>{t.members.length} reisgenoten</div>
                </div>
              </div>
            </button>
          ))}
        </div>
      </div>
    </div>
  );
}

// ─── Sidebar ────────────────────────────────────────────────────────
function WebSidebar({ active, signOut }){
  return (
    <div style={{
      borderRight:"1px solid var(--vp-line)", background:"var(--vp-bg-sub)",
      display:"flex", flexDirection:"column", padding:"24px 18px",
    }}>
      <div style={{display:"flex", alignItems:"center", gap:10, padding:"4px 6px 22px"}}>
        <div style={{
          width:28, height:28, borderRadius:8, background:"var(--vp-fg)", color:"var(--vp-bg)",
          display:"flex", alignItems:"center", justifyContent:"center",
          fontFamily:"var(--vp-display)", fontWeight:700, fontSize:16, fontStyle:"var(--vp-display-style)",
        }}>v</div>
        <div style={{fontSize:14, fontWeight:600, letterSpacing:0.2}}>vakantie<span style={{color:"var(--vp-fg-mut)"}}>.app</span></div>
      </div>

      <div style={{fontSize:10, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", padding:"4px 8px 8px"}}>Navigatie</div>
      <SBItem icon={<Ic.list s={14}/>} label="Mijn reizen" active={active==="trips"}/>
      <SBItem icon={<Ic.search s={14}/>} label="Verkennen"/>
      <SBItem icon={<Ic.bell s={14}/>} label="Updates" badge="3"/>

      <div style={{fontSize:10, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", padding:"22px 8px 8px"}}>Reizen</div>
      {SAMPLE_TRIPS.map((t,i)=>(
        <SBItem key={t.id} swatch={t.cover} label={t.title} sub={t.dates.split(" — ")[0]}/>
      ))}

      <div style={{flex:1}}/>

      <div style={{
        display:"flex", alignItems:"center", gap:10, padding:"10px 8px",
        borderTop:"1px solid var(--vp-line)", marginTop:8,
      }}>
        <Avatar m={SAMPLE_TRIPS[0].members[0]} size={30}/>
        <div style={{flex:1, minWidth:0}}>
          <div style={{fontSize:13, fontWeight:600}}>Sara de Wit</div>
          <div style={{fontSize:11, color:"var(--vp-fg-mut)"}}>sara@dewit.nl</div>
        </div>
        <button onClick={signOut} style={{
          border:"none", background:"transparent", color:"var(--vp-fg-mut)", cursor:"pointer",
        }}><Ic.more s={14}/></button>
      </div>
    </div>
  );
}

function SBItem({ icon, swatch, label, sub, active, badge }){
  return (
    <div style={{
      display:"flex", alignItems:"center", gap:10, padding:"9px 8px", marginBottom:2,
      borderRadius:"var(--vp-radius)", cursor:"pointer",
      background: active ? "var(--vp-bg)" : "transparent",
      border: active ? "1px solid var(--vp-line)" : "1px solid transparent",
      color: active ? "var(--vp-fg)" : "var(--vp-fg-sub)",
    }}>
      {icon && <span style={{display:"flex"}}>{icon}</span>}
      {swatch && <div style={{width:18, height:18, borderRadius:5, background:swatch, flexShrink:0}}/>}
      <div style={{flex:1, minWidth:0}}>
        <div style={{fontSize:13, fontWeight:500, whiteSpace:"nowrap", overflow:"hidden", textOverflow:"ellipsis"}}>{label}</div>
        {sub && <div style={{fontSize:10, color:"var(--vp-fg-mut)"}}>{sub}</div>}
      </div>
      {badge && <div style={{
        fontSize:10, fontWeight:700, padding:"2px 6px", borderRadius:999,
        background:"var(--vp-accent)", color:"var(--vp-bg)",
      }}>{badge}</div>}
    </div>
  );
}

// ─── Trip Detail ────────────────────────────────────────────────────
function WebTripDetail({ trip, members, packing, togglePack, addPack, tab, setTab, setScreen, signOut, invite, setInvite, addPlace, addToBudget }){
  const tabs = [
    {id:"dagen",    label:"Dagen"},
    {id:"paklijst", label:"Paklijst"},
    {id:"plekken",  label:"Plekken"},
    {id:"boeking",  label:"Boekingen"},
    {id:"budget",   label:"Budget"},
    {id:"kaart",    label:"Kaart"},
    {id:"leden",    label:"Leden"},
  ];

  return (
    <div style={{height:"100%", display:"grid", gridTemplateColumns:"260px 1fr", background:"var(--vp-bg)", color:"var(--vp-fg)", fontFamily:"var(--vp-body)"}}>
      <WebSidebar active="" signOut={signOut}/>
      <div style={{display:"flex", flexDirection:"column", overflow:"hidden"}}>
        {/* Hero */}
        <div style={{
          background: trip.cover, color:"#fff", padding:"22px 36px 24px", position:"relative",
          flexShrink:0,
        }}>
          <div style={{position:"absolute", inset:0, background:"linear-gradient(180deg, rgba(0,0,0,.15) 0%, rgba(0,0,0,.55) 100%)"}}/>
          <div style={{position:"relative", display:"flex", justifyContent:"space-between", alignItems:"flex-start"}}>
            <div style={{display:"flex", alignItems:"center", gap:10, fontSize:12, opacity:.85}}>
              <button onClick={()=>setScreen("trips")} style={{
                border:"none", background:"transparent", color:"#fff", cursor:"pointer", display:"flex", alignItems:"center", gap:6,
                fontSize:12,
              }}><Ic.back s={14}/> Mijn reizen</button>
              <span>/</span><span>{trip.title}</span>
            </div>
            <div style={{display:"flex", gap:8}}>
              <button style={iconBtnLightW}><Ic.share s={14}/></button>
              <button style={{...iconBtnLightW, width:"auto", padding:"0 14px", fontSize:12, gap:6}}>
                <Ic.user s={14}/> Uitnodigen
              </button>
            </div>
          </div>
          <div style={{position:"relative", marginTop:18, display:"flex", justifyContent:"space-between", alignItems:"flex-end"}}>
            <div>
              <div style={{fontSize:10, letterSpacing:2.5, textTransform:"uppercase", opacity:.85}}>{trip.country} · LIS-26</div>
              <h1 style={{
                fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
                fontSize:64, lineHeight:0.92, letterSpacing:"var(--vp-display-tracking)", margin:"6px 0 6px",
              }}>{trip.title}</h1>
              <div style={{fontSize:14, opacity:.9}}>{trip.dates} · {trip.nights} nachten · {trip.members.length} reisgenoten</div>
            </div>
            <div style={{display:"flex", gap:24, alignItems:"flex-end"}}>
              <Stat label="Nog" value={trip.daysAway} unit="dgn"/>
              <Stat label="Budget" value={`€${trip.budget}`} unit={`€${trip.spent} uit`}/>
              <Stat label="Plekken" value={trip.places.length} unit="gepind"/>
            </div>
          </div>
        </div>

        {/* Tabs */}
        <div style={{
          borderBottom:"1px solid var(--vp-line)",
          display:"flex", padding:"0 36px", background:"var(--vp-bg)", flexShrink:0,
        }}>
          {tabs.map(t=>(
            <button key={t.id} onClick={()=>setTab(t.id)} style={{
              padding:"14px 18px 12px", border:"none", background:"transparent", cursor:"pointer",
              color: tab===t.id ? "var(--vp-fg)" : "var(--vp-fg-mut)",
              fontFamily:"var(--vp-body)", fontSize:13, fontWeight: tab===t.id ? 600 : 500,
              borderBottom: tab===t.id ? "2px solid var(--vp-accent)" : "2px solid transparent",
              marginBottom:-1,
            }}>{t.label}</button>
          ))}
        </div>

        {/* Content */}
        <div style={{flex:1, overflow:"auto", padding:"28px 36px 40px"}}>
          {tab==="dagen"    && <DagenViewW trip={trip} members={members}/>}
          {tab==="paklijst" && <PaklijstViewW packing={packing} togglePack={togglePack} addPack={addPack} members={members}/>}
          {tab==="plekken"  && <PlekkenViewW trip={trip} addPlace={addPlace}/>}
          {tab==="boeking"  && <BoekingenViewW trip={trip} members={members}/>}
          {tab==="budget"   && <BudgetViewW trip={trip} members={members} addToBudget={addToBudget}/>}
          {tab==="kaart"    && <KaartViewW trip={trip}/>}
          {tab==="leden"    && <LedenViewW members={members} invite={invite} setInvite={setInvite}/>}
        </div>
      </div>
    </div>
  );
}

const iconBtnLightW = {
  height:32, minWidth:32, padding:0, borderRadius:8,
  border:"1px solid rgba(255,255,255,.3)", background:"rgba(255,255,255,.14)", backdropFilter:"blur(6px)",
  color:"#fff", cursor:"pointer", display:"flex", alignItems:"center", justifyContent:"center",
  fontFamily:"var(--vp-body)", fontWeight:500,
};

function Stat({label, value, unit}){
  return (
    <div style={{color:"#fff", textAlign:"right"}}>
      <div style={{fontSize:10, letterSpacing:2, textTransform:"uppercase", opacity:.7}}>{label}</div>
      <div style={{
        fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
        fontSize:30, lineHeight:1, marginTop:2,
      }}>{value}</div>
      <div style={{fontSize:11, opacity:.8, marginTop:2}}>{unit}</div>
    </div>
  );
}

// ─── Web Tab Views ──────────────────────────────────────────────────
function H2({ kicker, title, right }){
  return (
    <div style={{display:"flex", justifyContent:"space-between", alignItems:"flex-end", marginBottom:20}}>
      <div>
        <div style={{fontSize:10, letterSpacing:2.5, textTransform:"uppercase", color:"var(--vp-fg-mut)"}}>{kicker}</div>
        <h2 style={{
          fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
          fontSize:34, lineHeight:1, margin:"4px 0 0",
        }}>{title}</h2>
      </div>
      {right}
    </div>
  );
}

function DagenViewW({ trip, members }){
  const memById = Object.fromEntries(members.map(m=>[m.id,m]));
  return (
    <div>
      <H2 kicker={`${trip.days.length} dagen`} title="Dagschema"
        right={<button style={btnGhostW}><Ic.plus s={14}/> Dag toevoegen</button>}/>
      <div style={{display:"flex", flexDirection:"column", gap:28}}>
        {trip.days.map((d, di)=>(
          <div key={di} style={{display:"grid", gridTemplateColumns:"110px 1fr", gap:24, alignItems:"start"}}>
            <div style={{position:"sticky", top:0}}>
              <div style={{
                fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
                fontSize:60, lineHeight:0.9, color:"var(--vp-accent)",
              }}>{String(di+1).padStart(2,"0")}</div>
              <div style={{fontSize:13, fontWeight:600, marginTop:6}}>{d.date}</div>
              <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>{d.label}</div>
              <div style={{fontSize:12, color:"var(--vp-fg-mut)", marginTop:8}}>{d.weather}</div>
            </div>
            <div style={{display:"grid", gridTemplateColumns:"repeat(2, 1fr)", gap:10}}>
              {d.items.map((it, ii)=>(
                <div key={ii} style={{
                  border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius)",
                  padding:14, background:"var(--vp-bg-sub)",
                  display:"flex", gap:12, alignItems:"flex-start",
                }}>
                  <div style={{
                    width:34, height:34, borderRadius:8,
                    background:"var(--vp-bg)", border:"1px solid var(--vp-line)", color:"var(--vp-fg)",
                    display:"flex", alignItems:"center", justifyContent:"center", flexShrink:0,
                  }}>{kindIcon(it.kind)}</div>
                  <div style={{flex:1, minWidth:0}}>
                    <div style={{fontSize:11, color:"var(--vp-fg-mut)", marginBottom:2}}>{it.t}</div>
                    <div style={{fontSize:14, fontWeight:500}}>{it.title}</div>
                    {it.liked && (
                      <div style={{display:"flex", alignItems:"center", gap:6, marginTop:6}}>
                        <AvatarStack members={it.liked.map(id=>memById[id]).filter(Boolean)} size={16} max={4}/>
                        <span style={{fontSize:11, color:"var(--vp-fg-mut)"}}>+{it.liked.length}</span>
                      </div>
                    )}
                  </div>
                  <Avatar m={memById[it.by]} size={20}/>
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

const btnGhostW = {
  padding:"8px 12px", background:"transparent", border:"1px solid var(--vp-line)",
  color:"var(--vp-fg)", borderRadius:"var(--vp-radius)", cursor:"pointer",
  fontFamily:"var(--vp-body)", fontSize:13, fontWeight:500,
  display:"inline-flex", alignItems:"center", gap:6,
};
const btnPrimaryW = {
  padding:"8px 12px", background:"var(--vp-fg)", border:"none",
  color:"var(--vp-bg)", borderRadius:"var(--vp-radius)", cursor:"pointer",
  fontFamily:"var(--vp-body)", fontSize:13, fontWeight:600,
  display:"inline-flex", alignItems:"center", gap:6,
};

function PaklijstViewW({ packing, togglePack, addPack, members }){
  const memById = Object.fromEntries(members.map(m=>[m.id,m]));
  const cats = [...new Set(packing.map(p=>p.cat))];
  const done = packing.filter(p=>p.done).length;
  const [text, setText] = useStateW("");
  return (
    <div>
      <H2 kicker={`${done} / ${packing.length} ingepakt`} title="Paklijst"
        right={
          <form onSubmit={(e)=>{e.preventDefault(); if(text.trim()){addPack(text.trim()); setText("");}}} style={{display:"flex", gap:8}}>
            <input value={text} onChange={e=>setText(e.target.value)} placeholder="Voeg item toe..."
              style={{...fieldInput, padding:"10px 14px", fontSize:13, width:240}}/>
            <button type="submit" style={btnPrimaryW}><Ic.plus s={14}/> Toevoegen</button>
          </form>
        }/>
      <div style={{marginBottom:24, height:6, background:"var(--vp-bg-sub)", borderRadius:999, overflow:"hidden"}}>
        <div style={{height:"100%", width:`${(done/packing.length)*100}%`, background:"var(--vp-accent)"}}/>
      </div>
      <div style={{display:"grid", gridTemplateColumns:"repeat(auto-fill, minmax(260px, 1fr))", gap:20}}>
        {cats.map(cat=>(
          <div key={cat} style={{
            border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius-lg)",
            padding:18, background:"var(--vp-bg-sub)",
          }}>
            <div style={{display:"flex", justifyContent:"space-between", alignItems:"baseline", marginBottom:12}}>
              <div style={{
                fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
                fontSize:20,
              }}>{cat}</div>
              <div style={{fontSize:11, color:"var(--vp-fg-mut)"}}>
                {packing.filter(p=>p.cat===cat && p.done).length}/{packing.filter(p=>p.cat===cat).length}
              </div>
            </div>
            <div style={{display:"flex", flexDirection:"column"}}>
              {packing.filter(p=>p.cat===cat).map(p=>(
                <div key={p.id} onClick={()=>togglePack(p.id)} style={{
                  display:"flex", alignItems:"center", gap:10, padding:"10px 0",
                  borderTop:"1px solid var(--vp-line)", cursor:"pointer",
                }}>
                  <div style={{
                    width:20, height:20, borderRadius:5, flexShrink:0,
                    border:`1.5px solid ${p.done ? "var(--vp-accent)":"var(--vp-line-strong)"}`,
                    background: p.done ? "var(--vp-accent)" : "transparent",
                    color: p.done ? "var(--vp-bg)" : "transparent",
                    display:"flex", alignItems:"center", justifyContent:"center",
                  }}>{p.done && <Ic.check s={12}/>}</div>
                  <div style={{flex:1, fontSize:13,
                    textDecoration: p.done ? "line-through" : "none",
                    color: p.done ? "var(--vp-fg-mut)" : "var(--vp-fg)",
                  }}>{p.text}</div>
                  <Avatar m={memById[p.who]} size={18}/>
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

function PlekkenViewW({ trip, addPlace }){
  const [text, setText] = useStateW("");
  return (
    <div>
      <H2 kicker={`${trip.places.length} suggesties`} title="Plekken & restaurants"
        right={
          <form onSubmit={(e)=>{e.preventDefault(); if(text.trim()){addPlace(text.trim()); setText("");}}} style={{display:"flex", gap:8}}>
            <input value={text} onChange={e=>setText(e.target.value)} placeholder="Tip een plek..."
              style={{...fieldInput, padding:"10px 14px", fontSize:13, width:240}}/>
            <button type="submit" style={btnPrimaryW}><Ic.plus s={14}/> Voorstellen</button>
          </form>
        }/>
      <div style={{display:"grid", gridTemplateColumns:"1.4fr 1fr", gap:20}}>
        <div style={{display:"flex", flexDirection:"column", gap:10}}>
          {trip.places.map((p,i)=>(
            <div key={p.id} style={{
              border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius)",
              padding:16, background:"var(--vp-bg-sub)",
              display:"flex", alignItems:"center", gap:14,
            }}>
              <div style={{
                width:32, height:32, borderRadius:999, background:"var(--vp-accent)", color:"var(--vp-bg)",
                fontSize:13, fontWeight:700, display:"flex", alignItems:"center", justifyContent:"center", flexShrink:0,
              }}>{i+1}</div>
              <div style={{flex:1, minWidth:0}}>
                <div style={{fontSize:11, color:"var(--vp-fg-mut)", letterSpacing:1.2, textTransform:"uppercase"}}>{p.kind}</div>
                <div style={{
                  fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
                  fontSize:19, lineHeight:1.15, marginTop:2,
                }}>{p.name}</div>
                <div style={{fontSize:12, color:"var(--vp-fg-sub)", marginTop:4}}>{p.note}</div>
              </div>
              <div style={{display:"flex", alignItems:"center", gap:4, color:"var(--vp-accent)", fontSize:13, fontWeight:600}}>
                <Ic.star s={14}/>{p.liked}
              </div>
            </div>
          ))}
        </div>
        <div>
          <MiniMap pins={5} height={420} label={trip.title}/>
        </div>
      </div>
    </div>
  );
}

function BoekingenViewW({ trip, members }){
  const memById = Object.fromEntries(members.map(m=>[m.id,m]));
  const total = trip.bookings.reduce((a,b)=>a+b.cost,0);
  return (
    <div>
      <H2 kicker={`Totaal € ${total}`} title="Boekingen"
        right={<button style={btnPrimaryW}><Ic.plus s={14}/> Boeking toevoegen</button>}/>
      <div style={{
        border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius-lg)",
        overflow:"hidden", background:"var(--vp-bg-sub)",
      }}>
        <div style={{
          display:"grid", gridTemplateColumns:"110px 1fr 140px 140px 100px 60px",
          padding:"10px 18px", fontSize:10, letterSpacing:1.5, textTransform:"uppercase", color:"var(--vp-fg-mut)",
          borderBottom:"1px solid var(--vp-line)", background:"var(--vp-bg)",
        }}>
          <div>Type</div><div>Boeking</div><div>Datum</div><div>Boekingscode</div><div style={{textAlign:"right"}}>Bedrag</div><div></div>
        </div>
        {trip.bookings.map(b=>(
          <div key={b.id} style={{
            display:"grid", gridTemplateColumns:"110px 1fr 140px 140px 100px 60px", alignItems:"center",
            padding:"14px 18px", fontSize:13, borderBottom:"1px solid var(--vp-line)",
          }}>
            <div style={{fontSize:11, color:"var(--vp-fg-mut)", textTransform:"uppercase", letterSpacing:1.2}}>{b.type}</div>
            <div style={{fontWeight:600}}>{b.title}</div>
            <div style={{color:"var(--vp-fg-sub)"}}>{b.date}</div>
            <div style={{fontFamily:"ui-monospace, monospace", fontSize:12, color:"var(--vp-fg-sub)"}}>{b.code}</div>
            <div style={{textAlign:"right", fontWeight:600}}>€ {b.cost}</div>
            <div style={{display:"flex", justifyContent:"flex-end"}}><Avatar m={memById[b.by]} size={22}/></div>
          </div>
        ))}
      </div>
    </div>
  );
}

function BudgetViewW({ trip, members, addToBudget }){
  const memById = Object.fromEntries(members.map(m=>[m.id,m]));
  const total = trip.budget_items.reduce((a,b)=>a+b.amount,0);
  const perPerson = Math.round(total/members.length);
  return (
    <div>
      <H2 kicker="Gedeelde uitgaven" title="Budget"
        right={<button onClick={()=>addToBudget()} style={btnPrimaryW}><Ic.plus s={14}/> Uitgave</button>}/>
      <div style={{display:"grid", gridTemplateColumns:"1fr 1fr 1fr", gap:14, marginBottom:24}}>
        <BigStat label="Begroting" value={`€ ${trip.budget}`} sub={`voor ${members.length} personen`}/>
        <BigStat label="Uitgegeven" value={`€ ${total}`} sub={`${Math.round((total/trip.budget)*100)}% van budget`} accent/>
        <BigStat label="Per persoon" value={`€ ${perPerson}`} sub={`gedeeld door ${members.length}`}/>
      </div>
      <div style={{display:"grid", gridTemplateColumns:"1.4fr 1fr", gap:24}}>
        <div>
          <div style={{fontSize:11, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", marginBottom:10}}>Uitgaven</div>
          <div style={{display:"flex", flexDirection:"column"}}>
            {trip.budget_items.map(e=>(
              <div key={e.id} style={{
                display:"flex", alignItems:"center", gap:14, padding:"14px 0",
                borderBottom:"1px solid var(--vp-line)",
              }}>
                <Avatar m={memById[e.who]} size={32}/>
                <div style={{flex:1, minWidth:0}}>
                  <div style={{fontSize:14, fontWeight:500}}>{e.title}</div>
                  <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>betaald door {memById[e.who].name.split(" ")[0]} · gedeeld door {members.length}</div>
                </div>
                <div style={{fontSize:14, fontWeight:600}}>€ {e.amount}</div>
              </div>
            ))}
          </div>
        </div>
        <div>
          <div style={{fontSize:11, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", marginBottom:10}}>Wie staat waar?</div>
          <div style={{
            border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius-lg)",
            padding:16, background:"var(--vp-bg-sub)",
          }}>
            {members.map((m,i)=>{
              const paid = trip.budget_items.filter(e=>e.who===m.id).reduce((a,b)=>a+b.amount,0);
              const owed = perPerson - paid;
              return (
                <div key={m.id} style={{
                  display:"flex", alignItems:"center", gap:12, padding:"10px 0",
                  borderTop: i===0 ? "none" : "1px solid var(--vp-line)",
                }}>
                  <Avatar m={m} size={26}/>
                  <div style={{flex:1, fontSize:13, fontWeight:500}}>{m.name.split(" ")[0]}</div>
                  <div style={{fontSize:13, fontWeight:600, color: owed>0 ? "var(--vp-accent)" : "var(--vp-fg-mut)"}}>
                    {owed>0 ? `krijgt € ${owed}` : owed<0 ? `betaalt € ${Math.abs(owed)}` : "✓ gelijk"}
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </div>
    </div>
  );
}

function BigStat({label, value, sub, accent}){
  return (
    <div style={{
      padding:18, border:"1px solid var(--vp-line)",
      borderRadius:"var(--vp-radius-lg)", background: accent ? "var(--vp-bg-sub)" : "var(--vp-bg)",
    }}>
      <div style={{fontSize:10, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)"}}>{label}</div>
      <div style={{
        fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)", fontStyle:"var(--vp-display-style)",
        fontSize:38, lineHeight:1, margin:"6px 0 4px",
        color: accent ? "var(--vp-accent)" : "var(--vp-fg)",
      }}>{value}</div>
      <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>{sub}</div>
    </div>
  );
}

function KaartViewW({ trip }){
  return (
    <div>
      <H2 kicker={`${trip.places.length} pinned`} title="Op de kaart"/>
      <div style={{display:"grid", gridTemplateColumns:"1.6fr 1fr", gap:24, alignItems:"start"}}>
        <MiniMap pins={7} height={460} label={trip.title}/>
        <div>
          <div style={{fontSize:11, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", marginBottom:10}}>Plekken</div>
          {trip.places.map((p,i)=>(
            <div key={p.id} style={{display:"flex", alignItems:"center", gap:12, padding:"12px 0", borderBottom:"1px solid var(--vp-line)"}}>
              <div style={{
                width:26, height:26, borderRadius:999, background:"var(--vp-accent)", color:"var(--vp-bg)",
                fontSize:11, fontWeight:700, display:"flex", alignItems:"center", justifyContent:"center", flexShrink:0,
              }}>{i+1}</div>
              <div style={{flex:1}}>
                <div style={{fontSize:13, fontWeight:500}}>{p.name}</div>
                <div style={{fontSize:11, color:"var(--vp-fg-mut)"}}>{p.kind}</div>
              </div>
              <Ic.arrow s={14}/>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

function LedenViewW({ members, invite, setInvite }){
  return (
    <div>
      <H2 kicker={`${members.length} reisgenoten`} title="Leden &amp; rollen"/>
      <div style={{display:"grid", gridTemplateColumns:"1.4fr 1fr", gap:24}}>
        <div style={{
          border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius-lg)",
          overflow:"hidden", background:"var(--vp-bg-sub)",
        }}>
          {members.map((m,i)=>(
            <div key={m.id} style={{
              display:"flex", alignItems:"center", gap:14, padding:"16px 18px",
              borderTop: i===0 ? "none" : "1px solid var(--vp-line)",
            }}>
              <Avatar m={m} size={42}/>
              <div style={{flex:1}}>
                <div style={{fontSize:15, fontWeight:600}}>{m.name}</div>
                <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>
                  {m.id==="sara" ? "sara@dewit.nl" : m.id==="tom" ? "tom@bakker.io" : m.id==="nik" ? "niki@janssen.nl" : "vera.smit@me.com"}
                </div>
              </div>
              <select defaultValue={m.role} style={{
                padding:"8px 12px", border:"1px solid var(--vp-line)",
                background:"var(--vp-bg)", color:"var(--vp-fg-sub)", borderRadius:"var(--vp-radius)", fontSize:13,
                fontFamily:"var(--vp-body)",
              }}>
                <option>Eigenaar</option><option>Bewerker</option><option>Kijker</option>
              </select>
              <button style={{
                width:32, height:32, border:"1px solid var(--vp-line)", background:"transparent",
                color:"var(--vp-fg-mut)", borderRadius:"var(--vp-radius)", cursor:"pointer",
                display:"flex", alignItems:"center", justifyContent:"center",
              }}><Ic.more s={14}/></button>
            </div>
          ))}
        </div>
        <div style={{
          border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius-lg)",
          padding:18, background:"var(--vp-bg-sub)",
        }}>
          <div style={{fontSize:11, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", marginBottom:10}}>Uitnodigen</div>
          <input value={invite} onChange={e=>setInvite(e.target.value)} placeholder="naam@email.nl"
            style={{...fieldInput, padding:"12px 14px", fontSize:13, marginBottom:8}}/>
          <select style={{...fieldInput, padding:"12px 14px", fontSize:13, marginBottom:12}} defaultValue="Bewerker">
            <option>Bewerker</option><option>Kijker</option>
          </select>
          <button style={{...btnPrimaryW, width:"100%", padding:"12px", justifyContent:"center"}}>Uitnodiging versturen</button>
          <div style={{
            marginTop:14, padding:"12px 14px", background:"var(--vp-bg)", border:"1px dashed var(--vp-line-strong)",
            borderRadius:"var(--vp-radius)",
          }}>
            <div style={{fontSize:10, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", marginBottom:4}}>Of deel de link</div>
            <div style={{display:"flex", justifyContent:"space-between", alignItems:"center"}}>
              <div style={{fontSize:12, fontFamily:"ui-monospace, monospace", color:"var(--vp-fg-sub)"}}>vakantie.app/lis-26?k=A2F8</div>
              <button style={{border:"none", background:"transparent", color:"var(--vp-accent)", fontSize:12, fontWeight:600, cursor:"pointer"}}>Kopieer</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

window.WebApp = WebApp;
