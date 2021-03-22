<ul class="nav flex-column nav-pills">



    <li class="nav-item mb-2">
        <a class="nav-link @if($refferer != 'sys.account.index') active @endif" id="informationTab-tab" data-toggle="tab" href="#informationTab">
            <span class="nav-icon">
                <i class="fal fa-user"></i>
            </span>
            <span class="nav-text">Personal Information</span>
        </a>
    </li>

    <li class="nav-item mb-2">
        <a class="nav-link" id="employmentTab-tab" data-toggle="tab" href="#employmentTab" aria-controls="employment">
            <span class="nav-icon">
                <i class="fal fa-user-tie"></i>
            </span>
            <span class="nav-text">Employment</span>
        </a>
    </li>

    <li class="nav-item mb-2">
        <a class="nav-link" id="credentialsTab-tab" data-toggle="tab" href="#credentialsTab" aria-controls="credentials">
            <span class="nav-icon">
                <i class="fal fa-key"></i>
            </span>
            <span class="nav-text">Credentials</span>
        </a>
    </li>

    <li class="nav-item mb-2">
        <a class="nav-link" id="settingsTab-tab" data-toggle="tab" href="#settingsTab" aria-controls="settings">
            <span class="nav-icon">
                <i class="fal fa-sliders-h"></i>
            </span>
            <span class="nav-text">Settings</span>
        </a>
    </li>

    <li class="nav-item mb-2">
        <a class="nav-link @if($refferer == 'sys.account.index') active @endif" id="aclTab-tab" data-toggle="tab" href="#aclTab" aria-controls="settings">
            <span class="nav-icon">
                <i class="fal fa-shield-check"></i>
            </span>
            <span class="nav-text">Access Control Level</span>
        </a>
    </li>

</ul>