<template>
    <div class="app">
        <AppHeader fixed>
            <SidebarToggler class="d-lg-none" display="md" mobile />
            <b-link class="navbar-brand" to="#">
            </b-link>
            <SidebarToggler class="d-md-down-none" display="lg" />
            <b-navbar-nav class="d-md-down-none">
                <b-nav-item class="px-3" to="/dashboard">{{ $t('Dashboard') }}</b-nav-item>
                <b-nav-item class="px-3" to="/users" exact>{{ $t('Users') }}</b-nav-item>
                <b-nav-item class="px-3">{{ $t('Settings') }}</b-nav-item>
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
                <b-nav-item class="d-md-down-none">
                    <i class="icon-bell"></i>
                    <b-badge pill variant="danger">5</b-badge>
                </b-nav-item>
                <b-nav-item class="d-md-down-none">
                    <i class="icon-list"></i>
                </b-nav-item>
                <b-nav-item class="d-md-down-none">
                    <i class="icon-location-pin"></i>
                </b-nav-item>
                <DefaultHeaderDropdownAccnt :profile = 'profile'/>
            </b-navbar-nav>
            <AsideToggler class="d-none d-lg-block" />
            <!--<AsideToggler class="d-lg-none" mobile />-->
        </AppHeader>
        <div class="app-body">
            <AppSidebar fixed>
                <SidebarHeader />
                <SidebarForm />
                <SidebarNav :navItems="nav"></SidebarNav>
                <SidebarFooter />
                <SidebarMinimizer />
            </AppSidebar>
            <main class="main">
                <Breadcrumb :list="list" />
                <div class="container-fluid">
                    <router-view></router-view>
                </div>
            </main>
            <AppAside fixed>
                <!--aside-->
                <DefaultAside />
            </AppAside>
        </div>
        <TheFooter>
            <!--footer-->
            <div>
                <span class="ml-1">&copy; {{ $t('2018 creativeLabs.') }}</span>
            </div>
            <div class="ml-auto">
                <span class="mr-1">{{ $t('Powered by') }}</span>
            </div>
        </TheFooter>
    </div>
</template>

<script>
    import nav from '@/_nav'
    import { Header as AppHeader, SidebarToggler, Sidebar as AppSidebar, SidebarFooter, SidebarForm, SidebarHeader, SidebarMinimizer, SidebarNav, Aside as AppAside, AsideToggler, Footer as TheFooter, Breadcrumb } from '@coreui/vue'
    import DefaultAside from './DefaultAside'
    import DefaultHeaderDropdownAccnt from './DefaultHeaderDropdownAccnt'

    export default {
        name: 'DefaultContainer',
        components: {
            AsideToggler,
            AppHeader,
            AppSidebar,
            AppAside,
            TheFooter,
            Breadcrumb,
            DefaultAside,
            DefaultHeaderDropdownAccnt,
            SidebarForm,
            SidebarFooter,
            SidebarToggler,
            SidebarHeader,
            SidebarNav,
            SidebarMinimizer
        },
        data() {
            return {
                nav: nav.items
            }
        },
        computed: {
            name() {
                return this.$route.name
            },
            list() {
                return this.$route.matched.filter((route) => route.name || route.meta.label)
            },
            profile() {
                return this.$store.getters['Profile/getProfile'];
            }
        },
        mounted() {
            Promise.all([this.$store.dispatch('Profile/getProfile')]).then(res => {

            }).catch(err => {

            })
        }
    }
</script>
