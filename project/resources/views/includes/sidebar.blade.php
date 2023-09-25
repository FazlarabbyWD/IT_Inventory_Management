<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('uploads/settings/'.$settingsInfo->logo_1)}}" class="logo-icon" alt="logo" style="height: 30px;width: unset;">
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{!! route('home') !!}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-home-circle"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-transfer"></i>
                </div>
                <div class="menu-title">Distributions</div>
            </a>
            <ul>
                <li> <a href="{!! route('Distributions Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add Distribution</a>
                </li>
                <li> <a href="{!! route('Distributions') !!}"><i class="bx bx-right-arrow-alt"></i>List Distribution</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-list-ol"></i>
                </div>
                <div class="menu-title">Products</div>
            </a>
            <ul>
                <li> <a href="{!! route('Products Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
                </li>
                <li> <a href="{!! route('Products') !!}"><i class="bx bx-right-arrow-alt"></i>List Product</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-book"></i>
                </div>
                <div class="menu-title">Contacts</div>
            </a>
            <ul>
                <li> <a href="{!! route('Contacts Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add Contact</a>
                </li>
                <li> <a href="{!! route('Contacts') !!}"><i class="bx bx-right-arrow-alt"></i>List Contact</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-tag"></i>
                </div>
                <div class="menu-title">Offices</div>
            </a>
            <ul>
                <li> <a href="{!! route('Offices Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add Office</a>
                </li>
                <li> <a href="{!! route('Offices') !!}"><i class="bx bx-right-arrow-alt"></i>List Office</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Categories</div>
            </a>
            <ul>
                <li> <a href="{!! route('Categories Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add Category</a>
                </li>
                <li> <a href="{!! route('Categories') !!}"><i class="bx bx-right-arrow-alt"></i>List Category</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-bookmarks"></i>
                </div>
                <div class="menu-title">Brands</div>
            </a>
            <ul>
                <li> <a href="{!! route('Brands Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add Brand</a>
                </li>
                <li> <a href="{!! route('Brands') !!}"><i class="bx bx-right-arrow-alt"></i>List Brand</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-filter"></i>
                </div>
                <div class="menu-title">Contact Types</div>
            </a>
            <ul>
                <li> <a href="{!! route('ContactTypes Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add Contact Type</a>
                </li>
                <li> <a href="{!! route('ContactTypes') !!}"><i class="bx bx-right-arrow-alt"></i>List Contact Type</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-filter"></i>
                </div>
                <div class="menu-title">Specification Types</div>
            </a>
            <ul>
                <li> <a href="{!! route('SpecificationTypes Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add Specification</a>
                </li>
                <li> <a href="{!! route('SpecificationTypes') !!}"><i class="bx bx-right-arrow-alt"></i>List Specification</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-user"></i>
                </div>
                <div class="menu-title">Users</div>
            </a>
            <ul>
                <li> <a href="{!! route('Users Create') !!}"><i class="bx bx-right-arrow-alt"></i>Add User</a>
                </li>
                <li> <a href="{!! route('Users') !!}"><i class="bx bx-right-arrow-alt"></i>List User</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{!! route('Settings Edit') !!}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-cog"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
        </li>


        <!--end navigation-->
    </div>
