<nav class="bg-gradient-to-r from-slate-100 via-blue-100 to-indigo-100 border-b border-slate-300 shadow-md" x-data="{ mobileMenuOpen: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4 lg:py-6">
            <!-- Enhanced Logo Section with Animations -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3 group">
                <!-- Logo Icon with Floating Animation -->
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-500 group-hover:scale-110 animate-float">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                        <path fill-rule="evenodd" d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h4a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <!-- Logo Text with Fade-in Animation -->
                <div class="text-left animate-fade-in-left">
                    <div class="text-lg sm:text-2xl font-bold text-slate-800 leading-tight group-hover:text-blue-600 transition-colors duration-300">LA ক্ষতিপূরণ</div>
                    <div class="text-xs sm:text-sm font-medium text-slate-600 leading-tight group-hover:text-slate-700 transition-colors duration-300">ম্যানেজমেন্ট সিস্টেম</div>
                </div>
            </a>
            
            <!-- Desktop Navigation Menu -->
            <div class="hidden lg:flex items-center space-x-4 xl:space-x-6">
                @auth
                    <!-- Compensation Cases with Submenu -->
                    <div class="relative" x-data="{ submenuOpen: false }">
                        <button @click="submenuOpen = !submenuOpen" 
                                @mouseenter="submenuOpen = true"
                                @mouseleave="submenuOpen = false"
                                class="group relative px-4 xl:px-6 py-3 rounded-xl text-sm xl:text-base font-semibold transition-all duration-300 {{ request()->routeIs('compensation.*') 
                                    ? 'bg-blue-600 text-white shadow-lg' 
                                    : 'text-slate-700 bg-white hover:bg-blue-50 hover:text-blue-700 hover:shadow-lg border border-slate-200' }}">
                            <div class="absolute inset-0 rounded-xl bg-blue-400/10 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                            <span class="relative z-10 transition-all duration-300 group-hover:translate-x-1 group-hover:font-bold flex items-center space-x-2">
                                <span>ক্ষতিপূরণ কেস</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': submenuOpen}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>

                        <!-- Desktop Submenu -->
                        <div x-show="submenuOpen" 
                             @mouseenter="submenuOpen = true"
                             @mouseleave="submenuOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50">
                            
                            <a href="{{ route('compensation.index') }}" 
                               class="block px-4 py-3 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 {{ request()->routeIs('compensation.index') ? 'bg-blue-50 text-blue-700 font-semibold' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold">সব ক্ষতিপূরণ কেস</div>
                                        <div class="text-xs text-slate-500">বিদ্যমান কেসগুলো দেখুন</div>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="{{ route('compensation.create') }}" 
                               class="block px-4 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-green-700 transition-colors duration-200 {{ request()->routeIs('compensation.create') ? 'bg-green-50 text-green-700 font-semibold' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold">নতুন কেস তৈরি</div>
                                        <div class="text-xs text-slate-500">নতুন ক্ষতিপূরণ কেস যোগ করুন</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('compensation.register') }}" 
                       class="group relative px-4 xl:px-6 py-3 rounded-xl text-sm xl:text-base font-semibold transition-all duration-300 {{ request()->routeIs('compensation.register') 
                           ? 'bg-blue-600 text-white shadow-lg' 
                           : 'text-slate-700 bg-white hover:bg-blue-50 hover:text-blue-700 hover:shadow-lg border border-slate-200' }}">
                        <div class="absolute inset-0 rounded-xl bg-blue-400/10 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                        <span class="relative z-10 transition-all duration-300 group-hover:translate-x-1 group-hover:font-bold">ক্ষতিপূরণ কেস রেজিস্টার</span>
                    </a>

                    @if(Auth::user()->is_super_user)
                        <a href="{{ route('admin.users.index') }}" 
                           class="group relative px-4 xl:px-6 py-3 rounded-xl text-sm xl:text-base font-semibold transition-all duration-300 {{ request()->routeIs('admin.users.*') 
                               ? 'bg-purple-600 text-white shadow-lg' 
                               : 'text-slate-700 bg-white hover:bg-purple-50 hover:text-purple-700 hover:shadow-lg border border-slate-200' }}">
                            <div class="absolute inset-0 rounded-xl bg-purple-400/10 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                            <span class="relative z-10 transition-all duration-300 group-hover:translate-x-1 group-hover:font-bold">ইউজার ম্যানেজমেন্ট</span>
                        </a>
                    @endif

                    <!-- Desktop User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="group flex items-center space-x-2 xl:space-x-3 px-3 xl:px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 hover:shadow-lg transition-all duration-300">
                            <div class="w-7 h-7 xl:w-8 xl:h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 xl:w-5 xl:h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-left hidden xl:block">
                                <div class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-slate-600">{{ Auth::user()->email }}</div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <!-- Desktop Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50">
                            
                            <div class="px-4 py-2 border-b border-slate-100">
                                <div class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-slate-600">{{ Auth::user()->email }}</div>
                            </div>
                            
                            <a href="{{ route('password.change') }}" 
                               class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>পাসওয়ার্ড পরিবর্তন</span>
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>লগআউট</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Desktop Login/Register Links -->
                    <a href="{{ route('login') }}" 
                       class="group relative px-4 xl:px-6 py-3 rounded-xl text-sm xl:text-base font-semibold transition-all duration-300 text-slate-700 bg-white hover:bg-blue-50 hover:text-blue-700 hover:shadow-lg border border-slate-200">
                        <div class="absolute inset-0 rounded-xl bg-blue-400/10 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                        <span class="relative z-10 transition-all duration-300 group-hover:translate-x-1 group-hover:font-bold">লগইন</span>
                    </a>
                    <a href="{{ route('register') }}" 
                       class="group relative px-4 xl:px-6 py-3 rounded-xl text-sm xl:text-base font-semibold transition-all duration-300 text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 hover:shadow-lg">
                        <span class="relative z-10 transition-all duration-300 group-hover:translate-x-1 group-hover:font-bold">রেজিস্ট্রেশন</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 hover:shadow-lg transition-all duration-300">
                    <svg class="w-6 h-6 text-slate-700" :class="{'hidden': mobileMenuOpen}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <svg class="w-6 h-6 text-slate-700" :class="{'hidden': !mobileMenuOpen}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="lg:hidden pb-4 border-t border-slate-200 mt-4 pt-4">
            
            @auth
                <!-- Mobile Primary Navigation Links (Most Important First) -->
                <div class="space-y-2 mx-2 mb-4">
                    <!-- Mobile Compensation Cases with Submenu -->
                    <div x-data="{ mobileSubmenuOpen: false }">
                        <button @click="mobileSubmenuOpen = !mobileSubmenuOpen" 
                                class="w-full text-left px-4 py-3 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('compensation.index', 'compensation.create') 
                                    ? 'bg-blue-600 text-white shadow-lg' 
                                    : 'text-slate-700 bg-white hover:bg-blue-50 hover:text-blue-700 border border-slate-200' }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>ক্ষতিপূরণ কেস</span>
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': mobileSubmenuOpen}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Mobile Submenu -->
                        <div x-show="mobileSubmenuOpen" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             class="mt-2 ml-4 space-y-2">
                            
                            <a href="{{ route('compensation.index') }}" 
                               class="block px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300 {{ request()->routeIs('compensation.index') 
                                   ? 'bg-blue-100 text-blue-700 border border-blue-200' 
                                   : 'text-slate-600 bg-slate-50 hover:bg-blue-50 hover:text-blue-700 border border-slate-200' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold">সব ক্ষতিপূরণ কেস</div>
                                        <div class="text-xs opacity-75">বিদ্যমান কেসগুলো দেখুন</div>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="{{ route('compensation.create') }}" 
                               class="block px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300 {{ request()->routeIs('compensation.create') 
                                   ? 'bg-green-100 text-green-700 border border-green-200' 
                                   : 'text-slate-600 bg-slate-50 hover:bg-green-50 hover:text-green-700 border border-slate-200' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold">নতুন কেস তৈরি</div>
                                        <div class="text-xs opacity-75">নতুন ক্ষতিপূরণ কেস যোগ করুন</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('compensation.register') }}" 
                       class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('compensation.register') 
                           ? 'bg-blue-600 text-white shadow-lg' 
                           : 'text-slate-700 bg-white hover:bg-blue-50 hover:text-blue-700 border border-slate-200' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span>ক্ষতিপূরণ কেস রেজিস্টার</span>
                        </div>
                    </a>

                    @if(Auth::user()->is_super_user)
                        <a href="{{ route('admin.users.index') }}" 
                           class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('admin.users.*') 
                               ? 'bg-purple-600 text-white shadow-lg' 
                               : 'text-slate-700 bg-white hover:bg-purple-50 hover:text-purple-700 border border-slate-200' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                <span>ইউজার ম্যানেজমেন্ট</span>
                            </div>
                        </a>
                    @endif
                </div>

                <!-- Divider -->
                <div class="border-t border-slate-200 mx-2 mb-4"></div>

                <!-- Mobile User Account Section -->
                <div class="mx-2 mb-4">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 px-2">অ্যাকাউন্ট</div>
                    
                    <!-- Compact User Info -->
                    <div class="px-3 py-2 bg-slate-50 rounded-lg mb-3 flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</div>
                            <div class="flex items-center space-x-2">
                                <div class="text-xs text-slate-600 truncate">{{ Auth::user()->email }}</div>
                                @if(Auth::user()->is_super_user)
                                    <span class="inline-block px-1.5 py-0.5 bg-purple-100 text-purple-800 text-xs font-semibold rounded">Admin</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Account Actions -->
                    <div class="space-y-2">
                        <a href="{{ route('password.change') }}" 
                           class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-300 text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>পাসওয়ার্ড পরিবর্তন</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-3 rounded-xl text-base font-semibold transition-all duration-300 text-red-600 bg-white hover:bg-red-50 border border-red-200 flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span>লগআউট</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Mobile Login/Register Links -->
                <div class="space-y-2 mx-2">
                    <a href="{{ route('login') }}" 
                       class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-300 text-slate-700 bg-white hover:bg-blue-50 hover:text-blue-700 border border-slate-200">
                        লগইন
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-300 text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700">
                        রেজিস্ট্রেশন
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

@keyframes fade-in-left {
    0% { opacity: 0; transform: translateX(-20px); }
    100% { opacity: 1; transform: translateX(0); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-fade-in-left {
    animation: fade-in-left 1s ease-out;
}

/* Smooth scrolling for the whole page */
html {
    scroll-behavior: smooth;
}

/* Custom hover effects */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:rotate-12 {
    transform: rotate(12deg);
}
</style>