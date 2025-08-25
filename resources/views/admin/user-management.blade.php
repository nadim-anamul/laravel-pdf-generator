@extends('layouts.app')

@section('title', 'ইউজার ম্যানেজমেন্ট - LA ক্ষতিপূরণ ম্যানেজমেন্ট')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">ইউজার ম্যানেজমেন্ট</h1>
                    <p class="text-slate-600 mt-2">নতুন রেজিস্ট্রেশন অনুমোদন এবং ইউজার পরিচালনা</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-purple-600">সুপার ইউজার</span>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Pending Registrations -->
        <div class="bg-white rounded-xl shadow-lg mb-8">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">অপেক্ষমাণ রেজিস্ট্রেশন ({{ $pendingUsers->total() }})</h2>
                </div>
            </div>
            
            <div class="p-6">
                @if($pendingUsers->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingUsers as $user)
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-slate-800">{{ $user->name }}</h3>
                                                <p class="text-sm text-slate-600">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                            <div>
                                                <span class="text-xs font-semibold text-slate-500 uppercase">রেজিস্ট্রেশনের তারিখ</span>
                                                <p class="text-sm text-slate-700">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                            @if($user->registration_note)
                                                <div>
                                                    <span class="text-xs font-semibold text-slate-500 uppercase">রেজিস্ট্রেশনের কারণ</span>
                                                    <p class="text-sm text-slate-700">{{ $user->registration_note }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2 ml-4">
                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>অনুমোদন</span>
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.users.reject', $user) }}" class="inline"
                                              onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ইউজারকে প্রত্যাখ্যান করতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>প্রত্যাখ্যান</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $pendingUsers->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-slate-600 mb-2">কোনো অপেক্ষমাণ রেজিস্ট্রেশন নেই</h3>
                        <p class="text-slate-500">সব নতুন রেজিস্ট্রেশন অনুমোদিত হয়ে গেছে।</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Approved Users -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">অনুমোদিত ইউজার ({{ $approvedUsers->total() }})</h2>
                </div>
            </div>
            
            <div class="p-6">
                @if($approvedUsers->count() > 0)
                    <div class="space-y-4">
                        @foreach($approvedUsers as $user)
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="flex items-center space-x-2">
                                                    <h3 class="text-lg font-semibold text-slate-800">{{ $user->name }}</h3>
                                                    @if($user->isSuperUser())
                                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">সুপার ইউজার</span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-slate-600">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3 text-sm">
                                            <div>
                                                <span class="text-xs font-semibold text-slate-500 uppercase">অনুমোদনের তারিখ</span>
                                                <p class="text-slate-700">{{ $user->approved_at ? $user->approved_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <span class="text-xs font-semibold text-slate-500 uppercase">অনুমোদনকারী</span>
                                                <p class="text-slate-700">{{ $user->approvedBy ? $user->approvedBy->name : 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <span class="text-xs font-semibold text-slate-500 uppercase">রেজিস্ট্রেশনের তারিখ</span>
                                                <p class="text-slate-700">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2 ml-4">
                                        @if(!$user->isSuperUser())
                                            <form method="POST" action="{{ route('admin.users.make-super', $user) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-purple-600 text-white rounded text-sm hover:bg-purple-700 transition-colors duration-200"
                                                        onclick="return confirm('আপনি কি নিশ্চিত যে এই ইউজারকে সুপার ইউজার বানাতে চান?')">
                                                    সুপার ইউজার বানান
                                                </button>
                                            </form>
                                        @else
                                            @if($user->id !== Auth::id())
                                                <form method="POST" action="{{ route('admin.users.remove-super', $user) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="px-3 py-1 bg-orange-600 text-white rounded text-sm hover:bg-orange-700 transition-colors duration-200"
                                                            onclick="return confirm('আপনি কি নিশ্চিত যে এই ইউজারের সুপার ইউজার স্ট্যাটাস সরাতে চান?')">
                                                        সুপার ইউজার সরান
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                        
                                        <!-- Password Reset Button -->
                                        <button type="button" 
                                                onclick="openPasswordResetModal({{ $user->id }}, '{{ $user->name }}')"
                                                class="px-3 py-1 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 transition-colors duration-200">
                                            পাসওয়ার্ড রিসেট
                                        </button>
                                        
                                        @if(!$user->is_super_user)
                                            <form method="POST" action="{{ route('admin.users.revoke', $user) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition-colors duration-200"
                                                        onclick="return confirm('আপনি কি নিশ্চিত যে এই ইউজারের অনুমোদন বাতিল করতে চান?')">
                                                    অনুমোদন বাতিল
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $approvedUsers->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-slate-600 mb-2">কোনো অনুমোদিত ইউজার নেই</h3>
                        <p class="text-slate-500">এখনো কোনো ইউজার অনুমোদিত হয়নি।</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Password Reset Modal -->
<div id="passwordResetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-800">পাসওয়ার্ড রিসেট</h3>
                <button onclick="closePasswordResetModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            
            <form id="passwordResetForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <p class="text-sm text-slate-600 mb-4">
                        ইউজার <strong id="resetUserName"></strong> এর জন্য নতুন পাসওয়ার্ড সেট করুন। 
                        ইউজার পরবর্তী লগইনে এই পাসওয়ার্ড পরিবর্তন করতে বাধ্য থাকবেন।
                    </p>
                </div>
                
                <div>
                    <label for="new_password" class="block text-sm font-semibold text-slate-700 mb-2">নতুন পাসওয়ার্ড</label>
                    <input
                        id="new_password"
                        name="new_password"
                        type="password"
                        required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="কমপক্ষে ৬ অক্ষরের পাসওয়ার্ড"
                    >
                </div>
                
                <div>
                    <label for="reset_reason" class="block text-sm font-semibold text-slate-700 mb-2">রিসেটের কারণ (ঐচ্ছিক)</label>
                    <textarea
                        id="reset_reason"
                        name="reset_reason"
                        rows="3"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none"
                        placeholder="কেন এই ইউজারের পাসওয়ার্ড রিসেট করা হচ্ছে?"
                    ></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button
                        type="button"
                        onclick="closePasswordResetModal()"
                        class="px-4 py-2 bg-slate-300 text-slate-700 rounded-lg hover:bg-slate-400 transition-colors duration-200"
                    >
                        বাতিল
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200"
                    >
                        পাসওয়ার্ড রিসেট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openPasswordResetModal(userId, userName) {
    document.getElementById('resetUserName').textContent = userName;
    document.getElementById('passwordResetForm').action = `/admin/users/${userId}/reset-password`;
    document.getElementById('passwordResetModal').classList.remove('hidden');
}

function closePasswordResetModal() {
    document.getElementById('passwordResetModal').classList.add('hidden');
    document.getElementById('passwordResetForm').reset();
}

// Close modal when clicking outside
document.getElementById('passwordResetModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePasswordResetModal();
    }
});
</script>

@endsection
