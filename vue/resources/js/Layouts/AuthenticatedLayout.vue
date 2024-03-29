<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
//console.log(usePage().props);
const isAuth = usePage().props.auth;
const isImpersonating = usePage().props.impersonate.id;
const hasRole = isAuth ? usePage().props.auth.user.roles : false;
const isadmin = hasRole ? usePage().props.auth.user.roles.filter(r => r.name == 'admin').length : false;
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                  Dashboard
                </NavLink>
                <NavLink v-if="isImpersonating" :href="route('user.stop')" :active="isImpersonating">
                  Stop
                </NavLink>
                <NavLink v-if="isAuth" :href="route('type.index')" :active="route().current('type.index')">
                  Types
                </NavLink>
                <NavLink v-if="isAuth" :href="route('warehouse.index')" :active="route().current('warehouse.index')">
                  Warehouses
                </NavLink>
                <NavLink v-if="isAuth" :href="route('owner.index')" :active="route().current('owner.index')">
                  Owners
                </NavLink>
                <NavLink v-if="isAuth" :href="route('config.index')" :active="route().current('config.index')">
                  Configs
                </NavLink>
                <NavLink v-if="isAuth" :href="route('device.index')" :active="route().current('device.index')">
                  Devices
                </NavLink>
                <NavLink v-if="isadmin" :href="route('role.index')" :active="route().current('role.index')">
                  Roles
                </NavLink>
                <NavLink v-if="isadmin" :href="route('user.index')" :active="route().current('user.index')">
                  Users
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <!-- Settings Dropdown -->
              <div class="ml-3 relative">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        {{ $page.props.auth.user.name }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                    <DropdownLink :href="route('logout')" method="post" as="button">
                      Log Out
                    </DropdownLink>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path :class="{
                    hidden: showingNavigationDropdown,
                    'inline-flex': !showingNavigationDropdown,
                  }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  <path :class="{
                    hidden: !showingNavigationDropdown,
                    'inline-flex': showingNavigationDropdown,
                  }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
              Dashboard
            </ResponsiveNavLink>
            <ResponsiveNavLink v-if="isImpersonating" :href="route('user.stop')" :active="isImpersonating">
              Stop
            </ResponsiveNavLink>
            <ResponsiveNavLink v-if="isAuth" :href="route('type.index')" :active="route().current('type.index')">
              Type
            </ResponsiveNavLink>
            <ResponsiveNavLink v-if="isAuth" :href="route('warehouse.index')" :active="route().current('warehouse.index')">
              Warehouses
            </ResponsiveNavLink>
            <ResponsiveNavLink v-if="isAuth" :href="route('owner.index')" :active="route().current('owner.index')">
              Owners
            </ResponsiveNavLink>
            <ResponsiveNavLink v-if="isAuth" :href="route('config.index')" :active="route().current('config.index')">
              Configs
            </ResponsiveNavLink>
            <ResponsiveNavLink v-if="isAuth" :href="route('device.index')" :active="route().current('device.index')">
              Devices
            </ResponsiveNavLink>
            <ResponsiveNavLink v-if="isadmin" :href="route('role.index')" :active="route().current('role.index')">
              Role
            </ResponsiveNavLink>
            <ResponsiveNavLink v-if="isadmin" :href="route('user.index')" :active="route().current('user.index')">
              User
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
              <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                {{ $page.props.auth.user.name }}
              </div>
              <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
            </div>

            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
              <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                Log Out
              </ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
