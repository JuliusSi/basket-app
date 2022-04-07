<template>
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <font-awesome-icon :icon="['fas', 'bars']" class="fa-icon"
                           fixed-width/>
    </a>
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
            <div class="sidebar-brand">
                <a href="#"><font-awesome-icon :icon="['fas', 'screwdriver-wrench']" class="fa-icon"
                                                 fixed-width/> {{ this.$t('admin.menu.control_panel') }}</a>
                <div id="close-sidebar">
                    <font-awesome-icon style="font-size: 14px; margin-bottom: 2px;" :icon="['fas', 'angle-left']" class="fa-icon"
                                       fixed-width/>
                </div>
            </div>
            <div class="sidebar-header">
                <div class="user-pic">
                    <img alt="Avatar" :src="user.image_path">
                </div>
                <div class="user-info">
          <span class="user-name">
            <strong>{{ user.username }}</strong>
          </span>
                    <span class="user-role">{{ this.$t('admin.menu.statuses.' + user.status) }}</span>
                </div>
            </div>
            <!-- sidebar-header  -->
            <div class="sidebar-menu">
                <ul>
                    <li class="sidebar-dropdown">
                        <a href="#">
                            <font-awesome-icon :icon="['fas', 'cog']" class="fa-icon"
                                               fixed-width/>
                            <span>{{ this.$t('admin.menu.courts_management') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="#">
                            <font-awesome-icon :icon="['fas', 'cog']" class="fa-icon"
                                               fixed-width/>
                            <span>{{ this.$t('admin.menu.users_management') }}</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a href="#"> <font-awesome-icon :icon="['fas', 'angle-right']" class="fa-icon"
                                                                    fixed-width/>
                                        <span>{{ this.$t('admin.menu.users') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <font-awesome-icon :icon="['fas', 'angle-right']" class="fa-icon"
                                                                    fixed-width/>
                                        <span>{{ this.$t('admin.menu.user_roles') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="/horizon">
                            <font-awesome-icon :icon="['fas', 'cog']" class="fa-icon"
                                               fixed-width/>
                            <span>Events</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- sidebar-menu  -->
        </div>
    </nav>
    <!-- sidebar-wrapper  -->
</template>

<script>

export default {
    props: ['user'],
}


jQuery(function ($) {

    $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
                .parent()
                .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function() {
        $(".page-wrapper").addClass("toggled");
    });




});
</script>
