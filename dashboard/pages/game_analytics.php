<link rel="stylesheet" href="/../dashboard/style/game_analytics.css">

<div class="game-analytics-page">
    <header class="ga-header">
        <div class="header-left">
            <h1>Game Analytics</h1>
            <p>Insightful analytics tailored for <strong>Developers</strong> and <strong>Gamers</strong></p>
        </div>
        <div class="header-right">
            <span>View as:</span>
            <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>
            <strong>Developer</strong>
        </div>
    </header>

    <div class="kpi-grid">
        <div class="kpi-card">
            <p class="kpi-title">Total Plays</p>
            <h2 class="kpi-value">1,245,301</h2>
            <p class="kpi-trend positive"><i class="fa-solid fa-arrow-up"></i> +3.7% this month</p>
        </div>
        <div class="kpi-card">
            <p class="kpi-title">Active Users</p>
            <h2 class="kpi-value">62,840</h2>
            <p class="kpi-trend positive"><i class="fa-solid fa-arrow-up"></i> +2.1% week</p>
        </div>
        <div class="kpi-card">
            <p class="kpi-title">Avg. Session</p>
            <h2 class="kpi-value">27m 40s</h2>
            <p class="kpi-trend negative"><i class="fa-solid fa-arrow-down"></i> -0.4% week</p>
        </div>
        <div class="kpi-card">
            <p class="kpi-title">7-day Retention</p>
            <h2 class="kpi-value">44.8%</h2>
            <p class="kpi-trend positive"><i class="fa-solid fa-arrow-up"></i> +1.6% week</p>
        </div>
    </div>

    <div class="chart-card">
        <div class="card-header">
            <h3><i class="fa-solid fa-chart-bar"></i> Plays & Active Users</h3>
            <div class="chart-legend">
                <span class="legend-item"><span class="legend-color total"></span> Total Plays</span>
                <span class="legend-item"><span class="legend-color active"></span> Active Users</span>
            </div>
        </div>
        <div class="chart-placeholder">
            <img src="https://picsum.photos/seed/chart1/800/300" alt="Plays and active users bar chart">
        </div>
    </div>

    <div class="bottom-section">
        <div class="filter-column">
            <div class="filter-card">
                <label for="date-range">Date Range</label>
                <div class="select-like" id="date-range">Last 7 days <i class="fa-solid fa-chevron-down"></i></div>
            </div>
            <div class="filter-card">
                <label for="platform">Platform</label>
                <div class="select-like" id="platform">All <i class="fa-solid fa-chevron-down"></i></div>
            </div>
            <div class="filter-card">
                <label for="region">Region</label>
                <div class="select-like" id="region">Global <i class="fa-solid fa-chevron-down"></i></div>
            </div>
            <div class="filter-card">
                <label for="version">Version/Patch</label>
                <div class="select-like" id="version">All <i class="fa-solid fa-chevron-down"></i></div>
            </div>
        </div>
        
        <div class="data-column">
            <div class="data-card">
                <h3><i class="fa-solid fa-triangle-exclamation"></i> Crash/Error Logs</h3>
                <ul class="data-list">
                    <li><span>Crashes</span> <strong>13</strong></li>
                    <li><span>Error Rate</span> <strong class="negative">0.12%</strong></li>
                    <li><span>Reports</span> <strong>31</strong></li>
                </ul>
            </div>
            <div class="data-card">
                 <h3><i class="fa-solid fa-comments"></i> User Feedback</h3>
                 <div class="rating-section">
                    <i class="fa-solid fa-star"></i> <strong>4.5</strong> (320 ratings)
                 </div>
                 <p class="feedback-quote">"Level 3 boss is too hard, but the pacing is great!"</p>
                 <div class="feedback-suggestions">
                    <p>Top Suggestion: <strong>Add more checkpoints</strong></p>
                    <ul>
                        <li>More rewards for daily logins</li>
                        <li>Reduce loading times</li>
                        <li>Add multiplayer mode</li>
                    </ul>
                 </div>
            </div>
            <div class="data-card full-span">
                <h3><i class="fa-solid fa-gamepad"></i> In-Game Events</h3>
                <ul class="data-list large">
                    <li><span>Achievements Unlocked</span> <strong>1,800</strong></li>
                    <li><span>Levels Completed</span> <strong>9,350</strong></li>
                    <li><span>Bosses Defeated</span> <strong>430</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>