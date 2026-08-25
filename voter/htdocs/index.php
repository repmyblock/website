<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="National Voter File — a non-partisan, open-source effort to document and standardize voter-file access across all 50 states.">
  <meta name="theme-color" content="#f7f8f4">
  <title>National Voter File</title>
  <style>
:root {
  --bg: #f7f8f4;
  --surface: #ffffff;
  --surface-2: #eef1e8;
  --ink: #142019;
  --muted: #5f6d64;
  --line: #d9dfd7;
  --accent: #1e6b45;
  --accent-dark: #164f35;
  --accent-soft: #dcebe1;
  --dark: #102018;
  --radius: 18px;
  --radius-sm: 11px;
  --shadow: 0 16px 50px rgba(20, 32, 25, .08);
  --max: 1180px;
}

* { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
  margin: 0;
  background: var(--bg);
  color: var(--ink);
  font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  line-height: 1.55;
  -webkit-font-smoothing: antialiased;
}
a { color: inherit; }
button, input { font: inherit; }
svg { width: 1.1rem; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; }

.container { width: min(calc(100% - 40px), var(--max)); margin: 0 auto; }
.sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
.skip-link { position: absolute; top: -100px; left: 12px; z-index: 1000; background: #fff; padding: 10px 14px; border-radius: 8px; }
.skip-link:focus { top: 12px; }

.site-header {
  position: sticky;
  top: 0;
  z-index: 100;
  backdrop-filter: blur(14px);
  background: rgba(247,248,244,.9);
  border-bottom: 1px solid rgba(217,223,215,.8);
}
.header-inner { min-height: 72px; display: flex; align-items: center; justify-content: space-between; gap: 24px; }
.brand { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; font-weight: 760; letter-spacing: -.01em; }
.brand-mark { display: inline-grid; place-items: center; width: 40px; height: 40px; border-radius: 10px; background: var(--ink); color: #fff; font-size: .72rem; letter-spacing: .08em; }
.site-nav { display: flex; align-items: center; gap: 24px; }
.site-nav a { color: #3e4c43; text-decoration: none; font-size: .94rem; font-weight: 630; }
.site-nav a:hover { color: var(--accent); }
.nav-toggle { display: none; width: 44px; height: 44px; border: 0; background: transparent; align-items: center; justify-content: center; flex-direction: column; gap: 5px; }
.nav-toggle span:not(.sr-only) { width: 22px; height: 2px; background: var(--ink); border-radius: 2px; }

.hero { padding: 90px 0 70px; overflow: hidden; }
.hero-grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(340px, .8fr); gap: 70px; align-items: center; }
.eyebrow { margin: 0 0 14px; color: var(--accent); font-size: .77rem; font-weight: 800; text-transform: uppercase; letter-spacing: .13em; }
h1, h2, h3, p { margin-top: 0; }
h1 { margin-bottom: 24px; max-width: 780px; font-size: clamp(3.1rem, 7vw, 6.2rem); line-height: .94; letter-spacing: -.055em; font-weight: 820; }
h2 { margin-bottom: 20px; font-size: clamp(2rem, 4vw, 3.6rem); line-height: 1.02; letter-spacing: -.042em; }
h3 { margin-bottom: 10px; font-size: 1.23rem; letter-spacing: -.02em; }
.hero-lede { max-width: 720px; margin-bottom: 30px; color: #435148; font-size: clamp(1.08rem, 1.9vw, 1.33rem); line-height: 1.65; }
.hero-actions, .open-source-actions { display: flex; flex-wrap: wrap; gap: 12px; }
.hero-note { margin: 20px 0 0; color: var(--muted); font-size: .9rem; }

.button { display: inline-flex; align-items: center; justify-content: center; min-height: 48px; padding: 0 20px; border: 1px solid transparent; border-radius: 999px; text-decoration: none; font-weight: 760; font-size: .94rem; transition: transform .15s ease, background .15s ease, border-color .15s ease; }
.button:hover { transform: translateY(-1px); }
.button-primary { background: var(--accent); color: white; }
.button-primary:hover { background: var(--accent-dark); }
.button-secondary { background: rgba(255,255,255,.6); border-color: var(--line); color: var(--ink); }
.button-secondary:hover { background: #fff; }
.button-small { min-height: 42px; padding: 0 16px; font-size: .88rem; }
.button-dark { background: #fff; color: var(--dark); }
.button-ghost { color: #fff; border-color: rgba(255,255,255,.3); }

.progress-card { position: relative; padding: 34px; border-radius: 28px; background: var(--surface); border: 1px solid var(--line); box-shadow: var(--shadow); }
.progress-card::after { content: ""; position: absolute; inset: auto -40px -45px auto; width: 150px; height: 150px; background: var(--accent-soft); border-radius: 50%; filter: blur(4px); z-index: -1; }
.progress-topline { display: flex; align-items: baseline; justify-content: space-between; gap: 20px; }
.progress-topline .eyebrow { margin-bottom: 0; }
.progress-percent { color: var(--accent); font-weight: 800; }
.progress-numbers { display: flex; align-items: baseline; gap: 12px; margin: 22px 0 20px; }
.progress-numbers strong { font-size: clamp(3.3rem, 7vw, 5.7rem); line-height: .9; letter-spacing: -.055em; }
.progress-numbers .slash { margin: 0 2px; color: #9eaaa1; font-weight: 500; }
.progress-numbers > span { max-width: 90px; color: var(--muted); font-size: .92rem; line-height: 1.2; }
.progress-track { height: 14px; overflow: hidden; border-radius: 999px; background: #e6eae5; }
.progress-fill { display: block; height: 100%; width: 18%; border-radius: inherit; background: var(--accent); transition: width .6s cubic-bezier(.2,.7,.2,1); }
.progress-meta { display: flex; justify-content: space-between; margin: 12px 0 20px; color: var(--muted); font-size: .84rem; }
.text-link { color: var(--accent-dark); font-weight: 760; text-decoration-thickness: 1px; text-underline-offset: 4px; }

.trust-strip { border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); background: rgba(255,255,255,.45); }
.trust-grid { display: grid; grid-template-columns: repeat(4, 1fr); }
.trust-grid > div { display: flex; gap: 14px; min-height: 122px; padding: 28px 24px; border-right: 1px solid var(--line); }
.trust-grid > div:first-child { padding-left: 0; }
.trust-grid > div:last-child { border-right: 0; }
.trust-grid p { margin: 0; color: var(--muted); font-size: .9rem; line-height: 1.45; }
.trust-grid strong { color: var(--ink); }
.trust-icon { color: var(--accent); font-size: .78rem; font-weight: 850; letter-spacing: .05em; }

.section { padding: 96px 0; }
.section-tint { background: var(--surface-2); }
.section-heading { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(300px, .75fr); gap: 70px; align-items: end; margin-bottom: 44px; }
.section-heading.narrow { grid-template-columns: 1fr; max-width: 760px; }
.section-heading h2 { margin-bottom: 0; }
.section-intro, .prose { color: var(--muted); font-size: 1.04rem; }

.state-toolbar { display: flex; justify-content: space-between; gap: 18px; margin-bottom: 28px; }
.search-box { display: flex; align-items: center; gap: 10px; width: min(100%, 420px); min-height: 48px; padding: 0 15px; background: #fff; border: 1px solid var(--line); border-radius: 999px; color: #6d7a71; }
.search-box:focus-within { border-color: #8eb79d; box-shadow: 0 0 0 4px rgba(30,107,69,.08); }
.search-box input { width: 100%; border: 0; outline: 0; background: transparent; color: var(--ink); }
.state-actions { display: flex; gap: 10px; }
.state-grid { display: grid; grid-template-columns: repeat(5, minmax(0,1fr)); gap: 10px; }
.state-card { display: flex; align-items: center; gap: 12px; min-height: 70px; padding: 13px 14px; background: rgba(255,255,255,.72); border: 1px solid var(--line); border-radius: var(--radius-sm); text-decoration: none; transition: transform .14s ease, background .14s ease, border-color .14s ease; }
.state-card:hover { transform: translateY(-2px); background: #fff; border-color: #b8c5bc; }
.state-abbr { display: grid; place-items: center; flex: 0 0 38px; height: 38px; border-radius: 9px; background: var(--accent-soft); color: var(--accent-dark); font-weight: 850; font-size: .82rem; }
.state-name { min-width: 0; font-weight: 690; font-size: .91rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.no-results { padding: 30px 0; color: var(--muted); text-align: center; }

.steps-grid { display: grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap: 14px; }
.step-card { min-height: 260px; padding: 28px; background: rgba(255,255,255,.7); border: 1px solid #d5ddcf; border-radius: var(--radius); }
.step-card p { margin-bottom: 0; color: var(--muted); }
.step-number { display: inline-grid; place-items: center; width: 38px; height: 38px; margin-bottom: 55px; border-radius: 50%; background: var(--ink); color: #fff; font-weight: 800; font-size: .83rem; }

.split-grid { display: grid; grid-template-columns: 1.05fr .95fr; gap: 100px; align-items: start; }
.prose p { margin-bottom: 20px; }

.contribution-section { padding-top: 20px; }
.contribution-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; padding: 58px; border-radius: 28px; background: #fff; border: 1px solid var(--line); box-shadow: var(--shadow); }
.contribution-grid > div:first-child > p:not(.eyebrow) { max-width: 600px; color: var(--muted); font-size: 1.05rem; }
.contribution-list { display: grid; gap: 1px; align-self: center; border: 1px solid var(--line); border-radius: var(--radius); overflow: hidden; }
.contribution-list > div { display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: var(--bg); }
.contribution-list span { display: grid; place-items: center; flex: 0 0 28px; width: 28px; height: 28px; border-radius: 50%; background: var(--accent-soft); color: var(--accent-dark); font-weight: 900; }
.contribution-list p { margin: 0; font-weight: 630; }

.open-source-section { padding-top: 10px; }
.open-source-card { display: flex; justify-content: space-between; align-items: center; gap: 50px; padding: 56px; border-radius: 28px; background: var(--dark); color: #fff; }
.open-source-card .eyebrow { color: #97d3ad; }
.open-source-card h2 { margin-bottom: 10px; }
.open-source-card p:not(.eyebrow) { max-width: 700px; margin-bottom: 0; color: #bec9c1; }

.site-footer { margin-top: 70px; padding: 55px 0 70px; border-top: 1px solid var(--line); }
.footer-grid { display: flex; justify-content: space-between; gap: 60px; }
.footer-grid > div p { max-width: 460px; margin: 18px 0 0; color: var(--muted); font-size: .9rem; }
.footer-grid nav { display: grid; grid-template-columns: repeat(2, auto); align-content: start; gap: 12px 28px; }
.footer-grid nav a { color: #48564d; text-decoration: none; font-weight: 620; font-size: .9rem; }
.footer-grid nav a:hover { color: var(--accent); }

@media (max-width: 1050px) {
  .hero-grid { grid-template-columns: 1fr; gap: 45px; }
  .progress-card { max-width: 650px; }
  .state-grid { grid-template-columns: repeat(4, minmax(0,1fr)); }
  .steps-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
  .trust-grid { grid-template-columns: repeat(2,1fr); }
  .trust-grid > div:nth-child(2) { border-right: 0; }
  .trust-grid > div:first-child { padding-left: 24px; }
  .trust-grid > div:nth-child(-n+2) { border-bottom: 1px solid var(--line); }
}

@media (max-width: 760px) {
  .container { width: min(calc(100% - 28px), var(--max)); }
  .site-header { backdrop-filter: none; background: rgba(247,248,244,.98); }
  .header-inner { min-height: 64px; }
  .brand-text { font-size: .94rem; }
  .brand-mark { width: 36px; height: 36px; }
  .nav-toggle { display: flex; }
  .site-nav { position: absolute; left: 14px; right: 14px; top: 64px; display: none; padding: 14px; background: #fff; border: 1px solid var(--line); border-radius: 16px; box-shadow: var(--shadow); }
  .site-nav.open { display: grid; gap: 0; }
  .site-nav a { padding: 12px 10px; border-radius: 8px; }
  .site-nav a:hover { background: var(--bg); }
  .hero { padding: 65px 0 54px; }
  h1 { font-size: clamp(3.2rem, 17vw, 5rem); }
  .hero-actions .button { width: 100%; }
  .progress-card { padding: 25px; }
  .progress-numbers strong { font-size: 4.5rem; }
  .section { padding: 72px 0; }
  .section-heading, .split-grid, .contribution-grid { grid-template-columns: 1fr; gap: 28px; }
  .section-heading { margin-bottom: 34px; }
  .state-toolbar { align-items: stretch; flex-direction: column; }
  .search-box { width: 100%; }
  .state-actions { width: 100%; }
  .state-actions .button { flex: 1; }
  .state-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
  .steps-grid { grid-template-columns: 1fr; }
  .step-card { min-height: auto; }
  .step-number { margin-bottom: 35px; }
  .contribution-grid { padding: 30px 22px; }
  .open-source-card { align-items: flex-start; flex-direction: column; padding: 34px 24px; }
  .open-source-actions { width: 100%; }
  .open-source-actions .button { width: 100%; }
  .footer-grid { flex-direction: column; }
  .footer-grid nav { grid-template-columns: 1fr; }
}

@media (max-width: 480px) {
  .trust-grid { grid-template-columns: 1fr; }
  .trust-grid > div { border-right: 0; border-bottom: 1px solid var(--line); padding-left: 0; }
  .trust-grid > div:first-child { padding-left: 0; }
  .trust-grid > div:last-child { border-bottom: 0; }
  .state-grid { grid-template-columns: 1fr; }
  .state-actions { flex-direction: column; }
}

@media (prefers-reduced-motion: reduce) {
  html { scroll-behavior: auto; }
  *, *::before, *::after { transition: none !important; animation: none !important; }
}

</style>
</head>
<body>
  <a class="skip-link" href="#main">Skip to content</a>

  <header class="site-header" id="top">
    <div class="container header-inner">
      <a class="brand" href="/" aria-label="National Voter File home">
        <span class="brand-mark" aria-hidden="true">NVF</span>
        <span class="brand-text">National Voter File</span>
      </a>

      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
        <span class="sr-only">Toggle navigation</span>
        <span></span><span></span><span></span>
      </button>

      <nav class="site-nav" id="site-nav" aria-label="Primary navigation">
        <a href="#states">States</a>
        <a href="#how-it-works">How it works</a>
        <a href="/statepipeline/">State pipeline</a>
        <a href="/activistsurvey/">Volunteer survey</a>
        <a href="https://github.com/national-voter-file/national-voter-file" target="_blank" rel="noreferrer">GitHub</a>
      </nav>
    </div>
  </header>

  <main id="main">
    <section class="hero">
      <div class="container hero-grid">
        <div class="hero-copy">
          <p class="eyebrow"><FONT SIZE=+2>Open data infrastructure for democracy</FONT></p>
            <div class="eyebrow"><A HREF="https://repmyblock.org"><img src="images/RepMyBlock.svg" alt="Rep My Block" width=60></A>A Rep My Block project</div>

          <h1>Build the National Voter File.</h1>
          <p class="hero-lede">
            We are documenting how voter files are obtained, transformed, and used in every state — so campaigns, organizers, researchers, and civic groups do not have to start from scratch.
          </p>
          <div class="hero-actions">
            <a class="button button-primary" href="/statepipeline/">Explore the state pipeline</a>
            <a class="button button-secondary" href="/activistsurvey/">Help research your state</a>
          </div>
          <p class="hero-note">Non-partisan · Open source · Built state by state</p>
        </div>

        <aside class="progress-card" aria-labelledby="progress-title">
          <div class="progress-topline">
            <p class="eyebrow" id="progress-title">Current progress</p>
            <span class="progress-percent" id="progress-percent">18%</span>
          </div>
          <div class="progress-numbers">
            <strong><span id="completed-count">9</span><span class="slash">/</span>50</strong>
            <span>states completed</span>
          </div>
          <div class="progress-track" role="progressbar" aria-valuemin="0" aria-valuemax="50" aria-valuenow="9" aria-label="9 of 50 states completed">
            <span class="progress-fill" id="progress-fill"></span>
          </div>
          <div class="progress-meta">
            <span><b>9</b> complete</span>
            <span><b>41</b> to go</span>
          </div>
          <a class="text-link" href="/statepipeline/">See volunteer activity by state →</a>
        </aside>
      </div>
    </section>

    <section class="trust-strip" aria-label="Project principles">
      <div class="container trust-grid">
        <div><span class="trust-icon">01</span><p><strong>Collect</strong><br>Locate voter-file sources and access rules.</p></div>
        <div><span class="trust-icon">02</span><p><strong>Standardize</strong><br>Transform inconsistent state formats.</p></div>
        <div><span class="trust-icon">03</span><p><strong>Document</strong><br>Record sources, process, and provenance.</p></div>
        <div><span class="trust-icon">04</span><p><strong>Build</strong><br>Create reusable civic data infrastructure.</p></div>
      </div>
    </section>

    <section class="section" id="states">
      <div class="container">
        <div class="section-heading">
          <div>
            <p class="eyebrow">All 50 states</p>
            <h2>Find your state. Move the project forward.</h2>
          </div>
          <p class="section-intro">The live pipeline tracks volunteer activity. Use the directory below to find a state quickly, then open the pipeline or contribute what you know.</p>
        </div>

        <div class="state-toolbar">
          <label class="search-box" for="state-search">
            <span class="sr-only">Search for a state</span>
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/></svg>
            <input id="state-search" type="search" autocomplete="off" placeholder="Search states…">
          </label>
          <div class="state-actions">
            <a class="button button-small button-secondary" href="/statepipeline/">Open live pipeline</a>
            <a class="button button-small button-primary" href="/activistsurvey/">Volunteer</a>
          </div>
        </div>

        <div class="state-grid" id="state-grid" aria-live="polite"></div>
        <p class="no-results" id="no-results" hidden>No states match your search.</p>
      </div>
    </section>

    <section class="section section-tint" id="how-it-works">
      <div class="container">
        <div class="section-heading narrow">
          <div>
            <p class="eyebrow">How it works</p>
            <h2>Fifty systems. One common structure.</h2>
          </div>
        </div>

        <div class="steps-grid">
          <article class="step-card">
            <span class="step-number">1</span>
            <h3>Collect the source</h3>
            <p>Identify the official state or local source, request process, legal restrictions, fees, and update schedule.</p>
          </article>
          <article class="step-card">
            <span class="step-number">2</span>
            <h3>Transform the data</h3>
            <p>Convert state-specific files into consistent fields and formats that can be used across jurisdictions.</p>
          </article>
          <article class="step-card">
            <span class="step-number">3</span>
            <h3>Load and document</h3>
            <p>Store standardized data with enough provenance and documentation for someone else to reproduce the process.</p>
          </article>
          <article class="step-card">
            <span class="step-number">4</span>
            <h3>Make it useful</h3>
            <p>Build accessible tools and interfaces that help civic groups work with voter data responsibly and efficiently.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container split-grid">
        <div>
          <p class="eyebrow">Why this matters</p>
          <h2>Election data should not require rediscovering the process fifty times.</h2>
        </div>
        <div class="prose">
          <p>Every state handles voter files differently. Formats, fees, access rules, delivery methods, and update schedules vary widely.</p>
          <p>The National Voter File project creates a shared technical and research foundation so the next campaign, researcher, or civic group can build on verified work instead of repeating it.</p>
        </div>
      </div>
    </section>

    <section class="section contribution-section">
      <div class="container contribution-grid">
        <div>
          <p class="eyebrow">You can help without writing code</p>
          <h2>One verified answer can move a state forward.</h2>
          <p>Tell us about your local board of elections, voter-file experience, or the official sources you have already found.</p>
          <a class="button button-primary" href="/activistsurvey/">Take the volunteer survey</a>
        </div>

        <div class="contribution-list" aria-label="Ways to contribute">
          <div><span>✓</span><p>Find the official voter-file request page.</p></div>
          <div><span>✓</span><p>Confirm a fee, statute, form, or eligibility rule.</p></div>
          <div><span>✓</span><p>Identify state or county election contacts.</p></div>
          <div><span>✓</span><p>Test or improve an open-source data transformer.</p></div>
        </div>
      </div>
    </section>

    <section class="section open-source-section">
      <div class="container open-source-card">
        <div>
          <p class="eyebrow">Open source</p>
          <h2>Inspect it. Improve it. Fork it.</h2>
          <p>The project source is public on GitHub. Developers can review the data model, transformation work, issues, and history.</p>
        </div>
        <div class="open-source-actions">
          <a class="button button-dark" href="https://github.com/national-voter-file/national-voter-file" target="_blank" rel="noreferrer">View repository</a>
          <a class="button button-ghost" href="https://github.com/national-voter-file/national-voter-file/graphs/contributors" target="_blank" rel="noreferrer">Contributors</a>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <a class="brand footer-brand" href="#top">
          <span class="brand-mark">NVF</span>
          <span class="brand-text">National Voter File</span>
        </a>
        <p>The first free and open-source non-partisan national voter-file project.</p>
      </div>
      <nav aria-label="Footer navigation">
        <a href="/activistsurvey/">Volunteer Survey</a>
        <a href="/statepipeline/">State Pipeline</a>
        <a href="https://github.com/national-voter-file/national-voter-file/graphs/contributors" target="_blank" rel="noreferrer">Contributors</a>
        <a href="https://github.com/national-voter-file/national-voter-file" target="_blank" rel="noreferrer">GitHub</a>
      </nav>
    </div>
  </footer>

  <script>
const PROJECT = {
  completedStates: 9,
  totalStates: 50,
  pipelineUrl: "/statepipeline/"
};

const states = [
  ["AL", "Alabama"], ["AK", "Alaska"], ["AZ", "Arizona"], ["AR", "Arkansas"], ["CA", "California"],
  ["CO", "Colorado"], ["CT", "Connecticut"], ["DE", "Delaware"], ["FL", "Florida"], ["GA", "Georgia"],
  ["HI", "Hawaii"], ["ID", "Idaho"], ["IL", "Illinois"], ["IN", "Indiana"], ["IA", "Iowa"],
  ["KS", "Kansas"], ["KY", "Kentucky"], ["LA", "Louisiana"], ["ME", "Maine"], ["MD", "Maryland"],
  ["MA", "Massachusetts"], ["MI", "Michigan"], ["MN", "Minnesota"], ["MS", "Mississippi"], ["MO", "Missouri"],
  ["MT", "Montana"], ["NE", "Nebraska"], ["NV", "Nevada"], ["NH", "New Hampshire"], ["NJ", "New Jersey"],
  ["NM", "New Mexico"], ["NY", "New York"], ["NC", "North Carolina"], ["ND", "North Dakota"], ["OH", "Ohio"],
  ["OK", "Oklahoma"], ["OR", "Oregon"], ["PA", "Pennsylvania"], ["RI", "Rhode Island"], ["SC", "South Carolina"],
  ["SD", "South Dakota"], ["TN", "Tennessee"], ["TX", "Texas"], ["UT", "Utah"], ["VT", "Vermont"],
  ["VA", "Virginia"], ["WA", "Washington"], ["WV", "West Virginia"], ["WI", "Wisconsin"], ["WY", "Wyoming"]
];

function updateProgress() {
  const percent = Math.round((PROJECT.completedStates / PROJECT.totalStates) * 100);
  document.getElementById("completed-count").textContent = PROJECT.completedStates;
  document.getElementById("progress-percent").textContent = `${percent}%`;
  document.getElementById("progress-fill").style.width = `${percent}%`;

  const track = document.querySelector(".progress-track");
  track.setAttribute("aria-valuenow", PROJECT.completedStates);
  track.setAttribute("aria-label", `${PROJECT.completedStates} of ${PROJECT.totalStates} states completed`);
}

function stateCard([abbr, name]) {
  const link = document.createElement("a");
  link.className = "state-card";
  link.href = PROJECT.pipelineUrl;
  link.dataset.search = `${abbr} ${name}`.toLowerCase();
  link.setAttribute("aria-label", `${name}: open the state pipeline`);
  link.innerHTML = `<span class="state-abbr">${abbr}</span><span class="state-name">${name}</span>`;
  return link;
}

function renderStates(filter = "") {
  const grid = document.getElementById("state-grid");
  const noResults = document.getElementById("no-results");
  const query = filter.trim().toLowerCase();
  grid.innerHTML = "";

  const matches = states.filter(([abbr, name]) => `${abbr} ${name}`.toLowerCase().includes(query));
  matches.forEach(state => grid.appendChild(stateCard(state)));
  noResults.hidden = matches.length !== 0;
}

function setupSearch() {
  const search = document.getElementById("state-search");
  search.addEventListener("input", event => renderStates(event.target.value));
}

function setupNavigation() {
  const button = document.querySelector(".nav-toggle");
  const nav = document.getElementById("site-nav");

  button.addEventListener("click", () => {
    const open = button.getAttribute("aria-expanded") === "true";
    button.setAttribute("aria-expanded", String(!open));
    nav.classList.toggle("open", !open);
  });

  nav.addEventListener("click", event => {
    if (event.target.matches("a")) {
      nav.classList.remove("open");
      button.setAttribute("aria-expanded", "false");
    }
  });
}

updateProgress();
renderStates();
setupSearch();
setupNavigation();

</script>
</body>
</html>
