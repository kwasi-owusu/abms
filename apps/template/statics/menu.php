<div class="container-fluid">
    <div id="two-column-menu">
    </div>
    <ul class="navbar-nav" id="navbar-nav">
        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
        <li class="nav-item">
            <a class="nav-link menu-link" href="admin">
                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
            </a>
        </li> <!-- end Dashboard Menu -->
        <li class="nav-item">
            <a class="nav-link menu-link" href="settings">
                <i class="ri-settings-3-line"></i> <span data-key="t-apps">Settings</span>
            </a>
        </li> <!-- end Dashboard Menu -->
        <li class="nav-item">
            <a class="nav-link menu-link" href="#" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                <i class="ri-layout-4-fill"></i> <span data-key="t-apps">Agency Management</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarApps">
                <ul class="nav nav-sm flex-column sub">

                    <li class="nav-item">
                        <a href="agency_master" class="nav-link" data-key="t-projects">
                            Agency Master
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="agency_setup" class="nav-link" data-key="t-projects">
                            Agency Setup
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_agents" class="nav-link" data-key="t-projects">
                            Manage Agents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="agency_analytics" class="nav-link" data-key="t-projects">
                            Agency Analytics
                        </a>
                    </li>
                    
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                <i class="ri-user-fill"></i> <span data-key="t-apps">User Management</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarApps">
                <ul class="nav nav-sm flex-column sub">
                    <li class="nav-item">
                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                            Add User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                            Manage User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                            My Account
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Transactions</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarLayouts">
                <ul class="nav nav-sm flex-column sub">
                    <li class="nav-item">
                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">Select Opening Balance</a>
                    </li>
                    <li class="nav-item">
                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">Buy E-Cash</a>
                    </li>
                    <li class="nav-item">
                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">Sell & Buy Cash</a>
                    </li>
                    <li class="nav-item">
                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">E-Cash to Cash</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                <i class="ri-draft-fill"></i> <span data-key="t-authentication">Approvals</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarAuth">
                <ul class="nav nav-sm flex-column sub">
                    <li class="nav-item">
                        <a href="daily_trends.html" target="_blank" class="nav-link" data-key="t-horizontal">Approve Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="monthly_trends.html" target="_blank" class="nav-link" data-key="t-detached">Approve Branches</a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="nav-item sub">
            <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                <i class="ri-bar-chart-horizontal-fill"></i><span data-key="t-authentication">Reports</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarAuth">
                <ul class="nav nav-sm flex-column sub">
                    <li class="nav-item">
                        <a href="daily_trends.html" target="_blank" class="nav-link" data-key="t-horizontal">Activity Report</a>
                    </li>
                    <li class="nav-item">
                        <a href="monthly_trends.html" target="_blank" class="nav-link" data-key="t-detached">Cash In Hand Report</a>
                    </li>
                    <li class="nav-item">
                        <a href="monthly_trends.html" target="_blank" class="nav-link" data-key="t-detached">E-Cash Transaction Report</a>
                    </li>
                    <li class="nav-item">
                        <a href="#sidebarProjects" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProjects" data-key="t-projects">
                            Transaction Report
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarProjects">
                            <ul class="nav nav-sm flex-column sub">
                                <li class="nav-item">
                                    <a href="buy_cash.html" class="nav-link" data-key="t-list"> UBA
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#sidebarProjects" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProjects" data-key="t-projects">
                            Commission Report
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarProjects">
                            <ul class="nav nav-sm flex-column sub">
                                <li class="nav-item">
                                    <a href="buy_cash.html" class="nav-link" data-key="t-list"> UBA
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</div>