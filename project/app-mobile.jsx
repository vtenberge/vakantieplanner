// app-mobile.jsx — Mobile screens for the vakantieplanner prototype.
// Renders inside an IOSDevice frame. Pulls theme + state from props.
// Screens: login → trips → trip-detail (tabs: dagen / paklijst / plekken / boekingen / budget / kaart / leden).

const { useState } = React;

function MobileApp({ trip, members, packing, togglePack, addPack, screen, setScreen, tab, setTab, signed, signIn, signOut, dark, invite, setInvite, addPlace, addToBudget, accentName }) {
  return (
    <div style={{
      width:"100%", height:"100%", display:"flex", flexDirection:"column",
      background:"var(--vp-bg)", color:"var(--vp-fg)", fontFamily:"var(--vp-body)",
      overflow:"hidden",
    }}>
      {!signed ? (
        <MobileLogin signIn={signIn}/>
      ) : screen === "trips" ? (
        <MobileTripList setScreen={setScreen} signOut={signOut}/>
      ) : (
        <MobileTripDetail trip={trip} members={members} packing={packing} togglePack={togglePack} addPack={addPack}
          tab={tab} setTab={setTab} setScreen={setScreen} invite={invite} setInvite={setInvite} addPlace={addPlace} addToBudget={addToBudget}/>
      )}
    </div>
  );
}

// ─── Login ──────────────────────────────────────────────────────────
function MobileLogin({ signIn }){
  return (
    <div style={{height:"100%", display:"flex", flexDirection:"column", padding:"110px 28px 36px"}}>
      <div style={{flex:1}}>
        <div style={{
          fontFamily:"var(--vp-body)", fontSize:11, letterSpacing:2.5, textTransform:"uppercase",
          color:"var(--vp-fg-mut)", marginBottom:24,
        }}>Vakantieplanner ★ 2026</div>
        <h1 style={{
          fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)",
          fontSize:54, lineHeight:0.95, letterSpacing:"var(--vp-display-tracking)",
          margin:"0 0 14px", fontStyle:"var(--vp-display-style)", color:"var(--vp-fg)",
        }}>Samen op&nbsp;reis,<br/><em style={{fontStyle:"italic", color:"var(--vp-accent)"}}>één lijstje.</em></h1>
        <p style={{fontSize:15, lineHeight:1.5, color:"var(--vp-fg-sub)", maxWidth:300, margin:"0 0 36px"}}>
          Plan elke reis met je groep — paklijsten, boekingen en budget op één plek.
        </p>

        <div style={{display:"flex", flexDirection:"column", gap:12}}>
          <label style={fieldLabel}>E-mail</label>
          <input defaultValue="sara@dewit.nl" style={fieldInput}/>
          <label style={{...fieldLabel, marginTop:6}}>Wachtwoord</label>
          <input type="password" defaultValue="••••••••" style={fieldInput}/>
        </div>
      </div>
      <div style={{display:"flex", flexDirection:"column", gap:10}}>
        <button onClick={signIn} style={primaryButton}>Inloggen</button>
        <button onClick={signIn} style={ghostButton}>Doorgaan met Apple</button>
        <div style={{textAlign:"center", marginTop:8, fontSize:13, color:"var(--vp-fg-mut)"}}>
          Geen account? <span style={{color:"var(--vp-accent)", fontWeight:600}}>Account aanmaken</span>
        </div>
      </div>
    </div>
  );
}

const fieldLabel = {
  fontFamily:"var(--vp-body)", fontSize:11, letterSpacing:1.5, textTransform:"uppercase",
  color:"var(--vp-fg-mut)",
};
const fieldInput = {
  width:"100%", padding:"14px 14px", boxSizing:"border-box",
  background:"var(--vp-bg-sub)", border:"1px solid var(--vp-line)",
  borderRadius:"var(--vp-radius)", fontFamily:"var(--vp-body)", fontSize:16, color:"var(--vp-fg)",
  outline:"none",
};
const primaryButton = {
  width:"100%", padding:"16px", border:"none", cursor:"pointer",
  background:"var(--vp-fg)", color:"var(--vp-bg)",
  fontFamily:"var(--vp-body)", fontSize:15, fontWeight:600, letterSpacing:0.2,
  borderRadius:"var(--vp-radius)",
};
const ghostButton = {
  width:"100%", padding:"16px", cursor:"pointer",
  background:"transparent", color:"var(--vp-fg)",
  border:"1px solid var(--vp-line)",
  fontFamily:"var(--vp-body)", fontSize:15, fontWeight:500,
  borderRadius:"var(--vp-radius)",
};

// ─── Trip List ──────────────────────────────────────────────────────
function MobileTripList({ setScreen, signOut }){
  return (
    <div style={{height:"100%", display:"flex", flexDirection:"column", overflow:"auto"}}>
      <div style={{padding:"66px 24px 12px", display:"flex", alignItems:"flex-start", justifyContent:"space-between"}}>
        <div>
          <div style={{fontSize:11, letterSpacing:2.5, textTransform:"uppercase", color:"var(--vp-fg-mut)"}}>Hoi Sara</div>
          <h1 style={{
            fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)",
            fontSize:38, lineHeight:1, letterSpacing:"var(--vp-display-tracking)",
            margin:"6px 0 0", fontStyle:"var(--vp-display-style)",
          }}>Mijn reizen</h1>
        </div>
        <button onClick={signOut} style={{
          width:38, height:38, borderRadius:999, border:"1px solid var(--vp-line)",
          background:"var(--vp-bg)", color:"var(--vp-fg)", cursor:"pointer",
          display:"flex", alignItems:"center", justifyContent:"center",
        }}><Ic.user/></button>
      </div>

      <div style={{padding:"14px 24px 0", display:"flex", gap:8}}>
        {["Aankomend","Ideeën","Afgelopen"].map((t,i)=>(
          <span key={t} style={{
            fontSize:12, fontWeight:500, padding:"6px 12px", borderRadius:999,
            background: i===0 ? "var(--vp-fg)" : "transparent",
            color: i===0 ? "var(--vp-bg)" : "var(--vp-fg-sub)",
            border: i===0 ? "none" : "1px solid var(--vp-line)",
          }}>{t}</span>
        ))}
      </div>

      <div style={{padding:"18px 24px 8px", display:"flex", flexDirection:"column", gap:14}}>
        {SAMPLE_TRIPS.map((t,i)=>(
          <button key={t.id} onClick={()=>i===0 && setScreen("detail")} style={{
            textAlign:"left", border:"1px solid var(--vp-line)",
            background:"var(--vp-bg)", padding:0, cursor: i===0 ? "pointer":"default",
            borderRadius:"var(--vp-radius-lg)", overflow:"hidden",
            opacity: i===0 ? 1 : 0.85,
          }}>
            <div style={{height:120, background:t.cover, position:"relative"}}>
              <div style={{position:"absolute", inset:0, background:"linear-gradient(180deg, transparent 40%, rgba(0,0,0,.35) 100%)"}}/>
              <div style={{position:"absolute", left:14, top:12, color:"#fff", fontSize:10, letterSpacing:2, textTransform:"uppercase", opacity:.85}}>
                {t.country} · {t.nights} nachten
              </div>
              <div style={{position:"absolute", left:14, bottom:12, color:"#fff",
                fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)",
                fontSize:28, lineHeight:1, fontStyle:"var(--vp-display-style)"}}>
                {t.title}
              </div>
              <div style={{position:"absolute", right:14, bottom:12}}>
                <AvatarStack members={t.members} size={22} max={4}/>
              </div>
            </div>
            <div style={{padding:"12px 14px", display:"flex", alignItems:"center", justifyContent:"space-between"}}>
              <div>
                <div style={{fontSize:13, fontWeight:600, color:"var(--vp-fg)"}}>{t.dates}</div>
                <div style={{fontSize:12, color:"var(--vp-fg-mut)", marginTop:2}}>{t.subtitle}</div>
              </div>
              <div style={{fontSize:11, color:"var(--vp-fg-mut)", textAlign:"right"}}>
                nog<br/><span style={{fontFamily:"var(--vp-display)", fontSize:22, color:"var(--vp-fg)", lineHeight:1}}>{t.daysAway}</span><br/>dagen
              </div>
            </div>
          </button>
        ))}
      </div>

      <button style={{
        margin:"4px 24px 24px", padding:"16px", cursor:"pointer",
        background:"var(--vp-bg-sub)", border:"1px dashed var(--vp-line-strong)",
        color:"var(--vp-fg-sub)", borderRadius:"var(--vp-radius)",
        display:"flex", alignItems:"center", justifyContent:"center", gap:8,
        fontFamily:"var(--vp-body)", fontSize:14, fontWeight:500,
      }}><Ic.plus s={16}/> Nieuwe reis</button>
    </div>
  );
}

// ─── Trip Detail ────────────────────────────────────────────────────
function MobileTripDetail({ trip, members, packing, togglePack, addPack, tab, setTab, setScreen, invite, setInvite, addPlace, addToBudget }){
  const tabs = [
    {id:"dagen",    label:"Dagen",    icon:<Ic.cal s={14}/>},
    {id:"paklijst", label:"Paklijst", icon:<Ic.list s={14}/>},
    {id:"plekken",  label:"Plekken",  icon:<Ic.pin s={14}/>},
    {id:"boeking",  label:"Boekingen",icon:<Ic.plane s={14}/>},
    {id:"budget",   label:"Budget",   icon:<Ic.euro s={14}/>},
    {id:"kaart",    label:"Kaart",    icon:<Ic.map s={14}/>},
    {id:"leden",    label:"Leden",    icon:<Ic.user s={14}/>},
  ];

  return (
    <div style={{height:"100%", display:"flex", flexDirection:"column"}}>
      {/* Hero header */}
      <div style={{
        background:trip.cover, color:"#fff", padding:"58px 20px 20px",
        position:"relative", flexShrink:0,
      }}>
        <div style={{position:"absolute", inset:0, background:"linear-gradient(180deg, rgba(0,0,0,.18) 0%, rgba(0,0,0,.55) 100%)"}}/>
        <div style={{position:"relative", display:"flex", justifyContent:"space-between", alignItems:"flex-start"}}>
          <button onClick={()=>setScreen("trips")} style={iconBtnLight}><Ic.back s={16}/></button>
          <div style={{display:"flex", gap:8}}>
            <button style={iconBtnLight}><Ic.share s={16}/></button>
            <button style={iconBtnLight}><Ic.more s={16}/></button>
          </div>
        </div>
        <div style={{position:"relative", marginTop:30}}>
          <div style={{fontSize:10, letterSpacing:2.5, textTransform:"uppercase", opacity:.85}}>{trip.country} · Reis #LIS-26</div>
          <h1 style={{
            fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)",
            fontSize:46, lineHeight:0.95, margin:"6px 0 8px", fontStyle:"var(--vp-display-style)",
            letterSpacing:"var(--vp-display-tracking)",
          }}>{trip.title}</h1>
          <div style={{fontSize:13, opacity:.9}}>{trip.dates} · {trip.nights} nachten</div>
          <div style={{display:"flex", alignItems:"center", justifyContent:"space-between", marginTop:18}}>
            <AvatarStack members={members} size={28} max={5}/>
            <button onClick={()=>setTab("leden")} style={{
              padding:"7px 12px", borderRadius:999, border:"1px solid rgba(255,255,255,.5)",
              background:"rgba(255,255,255,.12)", color:"#fff", fontSize:12, fontWeight:500, cursor:"pointer",
              backdropFilter:"blur(4px)",
            }}>Uitnodigen</button>
          </div>
        </div>
      </div>

      {/* Tabs */}
      <div style={{
        borderBottom:"1px solid var(--vp-line)",
        display:"flex", overflowX:"auto", flexShrink:0,
        background:"var(--vp-bg)",
      }}>
        {tabs.map(t=>(
          <button key={t.id} onClick={()=>setTab(t.id)} style={{
            padding:"14px 14px 12px", border:"none", background:"transparent", cursor:"pointer",
            display:"flex", alignItems:"center", gap:6, whiteSpace:"nowrap",
            color: tab===t.id ? "var(--vp-fg)" : "var(--vp-fg-mut)",
            fontFamily:"var(--vp-body)", fontSize:13, fontWeight: tab===t.id ? 600 : 500,
            borderBottom: tab===t.id ? "2px solid var(--vp-accent)" : "2px solid transparent",
            marginBottom: -1,
          }}>{t.icon}{t.label}</button>
        ))}
      </div>

      {/* Tab content (scrolls) */}
      <div style={{flex:1, overflow:"auto"}}>
        {tab==="dagen"    && <DagenView trip={trip} members={members}/>}
        {tab==="paklijst" && <PaklijstView packing={packing} togglePack={togglePack} addPack={addPack} members={members}/>}
        {tab==="plekken"  && <PlekkenView trip={trip} addPlace={addPlace}/>}
        {tab==="boeking"  && <BoekingenView trip={trip} members={members}/>}
        {tab==="budget"   && <BudgetView trip={trip} members={members} addToBudget={addToBudget}/>}
        {tab==="kaart"    && <KaartView trip={trip}/>}
        {tab==="leden"    && <LedenView members={members} invite={invite} setInvite={setInvite}/>}
      </div>
    </div>
  );
}

const iconBtnLight = {
  width:36, height:36, borderRadius:999,
  border:"1px solid rgba(255,255,255,.35)", background:"rgba(255,255,255,.14)", backdropFilter:"blur(6px)",
  color:"#fff", cursor:"pointer", display:"flex", alignItems:"center", justifyContent:"center",
};

// ─── Tab views ──────────────────────────────────────────────────────
function SectionTitle({ kicker, title, right }){
  return (
    <div style={{display:"flex", alignItems:"flex-end", justifyContent:"space-between", padding:"22px 20px 10px"}}>
      <div>
        <div style={{fontSize:10, letterSpacing:2.5, textTransform:"uppercase", color:"var(--vp-fg-mut)"}}>{kicker}</div>
        <h2 style={{
          fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)",
          fontSize:26, lineHeight:1, margin:"4px 0 0", fontStyle:"var(--vp-display-style)",
        }}>{title}</h2>
      </div>
      {right}
    </div>
  );
}

function DagenView({ trip, members }){
  const memById = Object.fromEntries(members.map(m=>[m.id,m]));
  return (
    <div>
      <SectionTitle kicker={`${trip.days.length} dagen gepland`} title="Dagschema"/>
      <div style={{padding:"0 20px 24px", display:"flex", flexDirection:"column", gap:20}}>
        {trip.days.map((d, di)=>(
          <div key={di}>
            <div style={{display:"flex", alignItems:"baseline", justifyContent:"space-between", marginBottom:10}}>
              <div style={{display:"flex", alignItems:"baseline", gap:10}}>
                <div style={{
                  fontFamily:"var(--vp-display)", fontSize:30, lineHeight:1, fontWeight:"var(--vp-display-w)",
                  color:"var(--vp-accent)", fontStyle:"var(--vp-display-style)",
                }}>{String(di+1).padStart(2,"0")}</div>
                <div>
                  <div style={{fontSize:14, fontWeight:600}}>{d.date}</div>
                  <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>{d.label}</div>
                </div>
              </div>
              <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>{d.weather}</div>
            </div>
            <div style={{borderLeft:"1px solid var(--vp-line)", paddingLeft:14, display:"flex", flexDirection:"column", gap:10}}>
              {d.items.map((it,ii)=>(
                <div key={ii} style={{
                  border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius)",
                  padding:"12px 12px", background:"var(--vp-bg-sub)",
                  display:"flex", gap:12, alignItems:"flex-start",
                }}>
                  <div style={{
                    width:32, height:32, borderRadius:8, flexShrink:0,
                    background:"var(--vp-bg)", color:"var(--vp-fg)",
                    border:"1px solid var(--vp-line)",
                    display:"flex", alignItems:"center", justifyContent:"center",
                  }}>{kindIcon(it.kind)}</div>
                  <div style={{flex:1, minWidth:0}}>
                    <div style={{fontSize:11, color:"var(--vp-fg-mut)", marginBottom:2}}>{it.t}</div>
                    <div style={{fontSize:14, fontWeight:500, color:"var(--vp-fg)"}}>{it.title}</div>
                    {it.liked && it.liked.length>0 && (
                      <div style={{display:"flex", alignItems:"center", gap:6, marginTop:6}}>
                        <AvatarStack members={it.liked.map(id=>memById[id]).filter(Boolean)} size={16} max={4}/>
                        <span style={{fontSize:11, color:"var(--vp-fg-mut)"}}>vinden dit leuk</span>
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

function PaklijstView({ packing, togglePack, addPack, members }){
  const memById = Object.fromEntries(members.map(m=>[m.id,m]));
  const cats = [...new Set(packing.map(p=>p.cat))];
  const done = packing.filter(p=>p.done).length;
  const [text, setText] = useState("");
  return (
    <div>
      <SectionTitle kicker={`${done} / ${packing.length} ingepakt`} title="Paklijst"/>
      <div style={{padding:"0 20px 12px"}}>
        <div style={{height:6, background:"var(--vp-bg-sub)", borderRadius:999, overflow:"hidden", marginBottom:18}}>
          <div style={{height:"100%", width:`${(done/packing.length)*100}%`, background:"var(--vp-accent)"}}/>
        </div>
      </div>
      <div style={{padding:"0 20px 12px"}}>
        <form onSubmit={(e)=>{e.preventDefault(); if(text.trim()){addPack(text.trim()); setText("");}}} style={{display:"flex", gap:8, marginBottom:14}}>
          <input value={text} onChange={e=>setText(e.target.value)} placeholder="Voeg toe — bijv. Reisstekker"
            style={{...fieldInput, padding:"10px 12px", fontSize:14}}/>
          <button type="submit" style={{
            width:42, background:"var(--vp-fg)", color:"var(--vp-bg)", border:"none",
            borderRadius:"var(--vp-radius)", cursor:"pointer", display:"flex", alignItems:"center", justifyContent:"center",
          }}><Ic.plus s={16}/></button>
        </form>
      </div>
      <div style={{padding:"0 20px 24px", display:"flex", flexDirection:"column", gap:16}}>
        {cats.map(cat=>(
          <div key={cat}>
            <div style={{fontSize:11, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", marginBottom:8}}>{cat}</div>
            <div style={{display:"flex", flexDirection:"column"}}>
              {packing.filter(p=>p.cat===cat).map(p=>(
                <div key={p.id} onClick={()=>togglePack(p.id)} style={{
                  display:"flex", alignItems:"center", gap:12, padding:"12px 0",
                  borderBottom:"1px solid var(--vp-line)", cursor:"pointer",
                }}>
                  <div style={{
                    width:22, height:22, borderRadius:6, flexShrink:0,
                    border:`1.5px solid ${p.done ? "var(--vp-accent)":"var(--vp-line-strong)"}`,
                    background: p.done ? "var(--vp-accent)" : "transparent",
                    color: p.done ? "var(--vp-bg)" : "transparent",
                    display:"flex", alignItems:"center", justifyContent:"center",
                  }}>{p.done && <Ic.check s={14}/>}</div>
                  <div style={{flex:1, fontSize:14,
                    textDecoration: p.done ? "line-through" : "none",
                    color: p.done ? "var(--vp-fg-mut)" : "var(--vp-fg)",
                  }}>{p.text}</div>
                  <Avatar m={memById[p.who]} size={20}/>
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

function PlekkenView({ trip, addPlace }){
  const [text, setText] = useState("");
  return (
    <div>
      <SectionTitle kicker={`${trip.places.length} suggesties`} title="Plekken & restaurants"/>
      <div style={{padding:"0 20px 14px"}}>
        <form onSubmit={(e)=>{e.preventDefault(); if(text.trim()){addPlace(text.trim()); setText("");}}} style={{display:"flex", gap:8}}>
          <input value={text} onChange={e=>setText(e.target.value)} placeholder="Tip een plek..."
            style={{...fieldInput, padding:"10px 12px", fontSize:14}}/>
          <button type="submit" style={{
            width:42, background:"var(--vp-fg)", color:"var(--vp-bg)", border:"none",
            borderRadius:"var(--vp-radius)", cursor:"pointer", display:"flex", alignItems:"center", justifyContent:"center",
          }}><Ic.plus s={16}/></button>
        </form>
      </div>
      <div style={{padding:"0 20px 24px", display:"flex", flexDirection:"column", gap:10}}>
        {trip.places.map(p=>(
          <div key={p.id} style={{
            border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius)",
            padding:14, background:"var(--vp-bg-sub)",
          }}>
            <div style={{display:"flex", justifyContent:"space-between", alignItems:"flex-start"}}>
              <div style={{flex:1}}>
                <div style={{fontSize:11, color:"var(--vp-fg-mut)", letterSpacing:1.2, textTransform:"uppercase", marginBottom:4}}>{p.kind}</div>
                <div style={{
                  fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)",
                  fontSize:18, lineHeight:1.15, fontStyle:"var(--vp-display-style)",
                }}>{p.name}</div>
                <div style={{fontSize:13, color:"var(--vp-fg-sub)", marginTop:6}}>{p.note}</div>
              </div>
              <div style={{display:"flex", alignItems:"center", gap:4, color:"var(--vp-accent)", fontSize:12, fontWeight:600}}>
                <Ic.star s={12}/>{p.liked}
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

function BoekingenView({ trip, members }){
  const memById = Object.fromEntries(members.map(m=>[m.id,m]));
  const total = trip.bookings.reduce((a,b)=>a+b.cost,0);
  return (
    <div>
      <SectionTitle kicker={`Totaal € ${total}`} title="Boekingen"/>
      <div style={{padding:"0 20px 24px", display:"flex", flexDirection:"column", gap:10}}>
        {trip.bookings.map(b=>(
          <div key={b.id} style={{
            border:"1px solid var(--vp-line)", borderRadius:"var(--vp-radius)",
            padding:14, background:"var(--vp-bg-sub)",
          }}>
            <div style={{display:"flex", justifyContent:"space-between", alignItems:"flex-start", marginBottom:8}}>
              <div style={{fontSize:11, letterSpacing:1.4, textTransform:"uppercase", color:"var(--vp-fg-mut)"}}>{b.type}</div>
              <div style={{fontSize:14, fontWeight:600}}>€ {b.cost}</div>
            </div>
            <div style={{fontSize:15, fontWeight:600, color:"var(--vp-fg)"}}>{b.title}</div>
            <div style={{display:"flex", alignItems:"center", justifyContent:"space-between", marginTop:8}}>
              <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>{b.date} · {b.code}</div>
              <Avatar m={memById[b.by]} size={20}/>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

function BudgetView({ trip, members, addToBudget }){
  const memById = Object.fromEntries(members.map(m=>[m.id,m]));
  const total = trip.budget_items.reduce((a,b)=>a+b.amount,0);
  const perPerson = Math.round(total/members.length);
  return (
    <div>
      <SectionTitle kicker={`Uitgegeven van € ${trip.budget}`} title="Budget"/>
      <div style={{padding:"0 20px 14px"}}>
        <div style={{display:"flex", alignItems:"baseline", gap:6, marginBottom:8}}>
          <div style={{
            fontFamily:"var(--vp-display)", fontWeight:"var(--vp-display-w)",
            fontSize:48, lineHeight:1, fontStyle:"var(--vp-display-style)",
          }}>€ {total}</div>
          <div style={{fontSize:13, color:"var(--vp-fg-mut)"}}>/ € {trip.budget}</div>
        </div>
        <div style={{height:6, background:"var(--vp-bg-sub)", borderRadius:999, overflow:"hidden"}}>
          <div style={{height:"100%", width:`${Math.min(100, (total/trip.budget)*100)}%`, background:"var(--vp-accent)"}}/>
        </div>
        <div style={{fontSize:12, color:"var(--vp-fg-mut)", marginTop:8}}>
          ≈ € {perPerson} per persoon
        </div>
      </div>
      <div style={{padding:"14px 20px 24px"}}>
        <div style={{fontSize:11, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", marginBottom:8}}>Uitgaven</div>
        {trip.budget_items.map(e=>(
          <div key={e.id} style={{
            display:"flex", alignItems:"center", gap:12, padding:"12px 0",
            borderBottom:"1px solid var(--vp-line)",
          }}>
            <Avatar m={memById[e.who]} size={28}/>
            <div style={{flex:1, minWidth:0}}>
              <div style={{fontSize:14, fontWeight:500}}>{e.title}</div>
              <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>betaald door {memById[e.who].name.split(" ")[0]} · gedeeld door {members.length}</div>
            </div>
            <div style={{fontSize:14, fontWeight:600}}>€ {e.amount}</div>
          </div>
        ))}
        <button onClick={()=>addToBudget()} style={{
          marginTop:14, width:"100%", padding:"14px",
          background:"var(--vp-bg-sub)", border:"1px dashed var(--vp-line-strong)",
          color:"var(--vp-fg-sub)", borderRadius:"var(--vp-radius)",
          fontSize:14, fontWeight:500, cursor:"pointer",
          display:"flex", alignItems:"center", justifyContent:"center", gap:8,
        }}><Ic.plus s={16}/> Uitgave toevoegen</button>
      </div>
    </div>
  );
}

function KaartView({ trip }){
  return (
    <div>
      <SectionTitle kicker={`${trip.places.length} pinned`} title="Op de kaart"/>
      <div style={{padding:"0 20px 16px"}}>
        <MiniMap pins={6} height={260} label={trip.title}/>
      </div>
      <div style={{padding:"0 20px 24px", display:"flex", flexDirection:"column", gap:8}}>
        {trip.places.slice(0,4).map((p, i)=>(
          <div key={p.id} style={{display:"flex", alignItems:"center", gap:12, padding:"10px 0", borderBottom:"1px solid var(--vp-line)"}}>
            <div style={{
              width:24, height:24, borderRadius:999, background:"var(--vp-accent)", color:"var(--vp-bg)",
              fontSize:11, fontWeight:700, display:"flex", alignItems:"center", justifyContent:"center",
              flexShrink:0,
            }}>{i+1}</div>
            <div style={{flex:1}}>
              <div style={{fontSize:14, fontWeight:500}}>{p.name}</div>
              <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>{p.kind}</div>
            </div>
            <Ic.arrow s={14}/>
          </div>
        ))}
      </div>
    </div>
  );
}

function LedenView({ members, invite, setInvite }){
  return (
    <div>
      <SectionTitle kicker={`${members.length} reisgenoten`} title="Wie reizen er mee"/>
      <div style={{padding:"0 20px 16px", display:"flex", flexDirection:"column"}}>
        {members.map(m=>(
          <div key={m.id} style={{
            display:"flex", alignItems:"center", gap:12, padding:"14px 0",
            borderBottom:"1px solid var(--vp-line)",
          }}>
            <Avatar m={m} size={42}/>
            <div style={{flex:1}}>
              <div style={{fontSize:15, fontWeight:600}}>{m.name}</div>
              <div style={{fontSize:12, color:"var(--vp-fg-mut)"}}>{m.role}</div>
            </div>
            <select defaultValue={m.role} style={{
              padding:"6px 8px", border:"1px solid var(--vp-line)",
              background:"var(--vp-bg)", color:"var(--vp-fg-sub)", borderRadius:6, fontSize:12,
              fontFamily:"var(--vp-body)",
            }}>
              <option>Eigenaar</option><option>Bewerker</option><option>Kijker</option>
            </select>
          </div>
        ))}
      </div>
      <div style={{padding:"6px 20px 24px"}}>
        <div style={{
          padding:16, background:"var(--vp-bg-sub)", border:"1px solid var(--vp-line)",
          borderRadius:"var(--vp-radius)",
        }}>
          <div style={{fontSize:11, letterSpacing:2, textTransform:"uppercase", color:"var(--vp-fg-mut)", marginBottom:8}}>Uitnodigen</div>
          <div style={{display:"flex", gap:8, marginBottom:10}}>
            <input value={invite} onChange={e=>setInvite(e.target.value)} placeholder="naam@email.nl"
              style={{...fieldInput, padding:"10px 12px", fontSize:14}}/>
            <button style={{
              padding:"10px 14px", background:"var(--vp-fg)", color:"var(--vp-bg)", border:"none",
              borderRadius:"var(--vp-radius)", cursor:"pointer", fontSize:13, fontWeight:600,
            }}>Verstuur</button>
          </div>
          <div style={{
            display:"flex", justifyContent:"space-between", alignItems:"center",
            padding:"10px 12px", background:"var(--vp-bg)", border:"1px dashed var(--vp-line-strong)",
            borderRadius:"var(--vp-radius)",
          }}>
            <div style={{fontSize:12, fontFamily:"var(--vp-mono, monospace)", color:"var(--vp-fg-sub)"}}>vakantie.app/lis-26?k=A2F8</div>
            <button style={{
              border:"none", background:"transparent", color:"var(--vp-accent)",
              fontSize:12, fontWeight:600, cursor:"pointer",
            }}>Kopieer</button>
          </div>
        </div>
      </div>
    </div>
  );
}

window.MobileApp = MobileApp;
