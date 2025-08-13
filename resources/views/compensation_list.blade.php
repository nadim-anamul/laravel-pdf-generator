@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ কেসের তালিকা')

@section('content')
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">ক্ষতিপূরণ কেসের তালিকা</h1>
            <a href="{{ route('compensation.create') }}"
                class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-700 hover:to-blue-500 text-white font-extrabold text-lg md:text-xl px-6 md:px-10 py-3 md:py-4 rounded-lg shadow-lg transform transition-all duration-500 ease-in-out hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 w-full sm:w-auto justify-center"
                >
                    <svg class="w-6 h-6 mr-2 -ml-1 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                    </svg>
                    নতুন ক্ষতিপূরণ কেস দায়ের
            </a>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <form method="GET" action="{{ route('compensation.index') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-64">
                    <label class="block text-sm font-medium text-gray-700 mb-2">অনুসন্ধান</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="এলএ কেস নং, ক্ষতিপূরণ কেস নং, আবেদনকারীর নাম, মৌজা নং, দাগ নং (SA/RS), জেএল নং লিখুন..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="min-w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-2">অবস্থা</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending" {{ ($status ?? 'pending') === 'pending' ? 'selected' : '' }}>চলমান</option>
                        <option value="done" {{ ($status ?? 'pending') === 'done' ? 'selected' : '' }}>নিষ্পত্তিকৃত</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        অনুসন্ধান করুন
                    </button>
                    <a href="{{ route('compensation.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        রিসেট
                    </a>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{!! session('success') !!}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ক্ষতিপূরণ কেস নং</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">এলএ কেস নং</th>
                        
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">আবেদনকারীগণ</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">মৌজা</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">দাগ নং</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compensations as $item)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $item->id }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $item->getBengaliValue('case_number') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $item->getBengaliValue('la_case_no') }}</p>
                        </td>
                        
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            @if(is_array($item->applicants))
                                @foreach($item->applicants as $index => $applicant)
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        <span class="text-blue-600 font-medium">#{{ $index + 1 }}:</span> 
                                        {{ is_array($applicant) ? ($applicant['name'] ?? '') : $applicant }}
                                    </p>
                                @endforeach
                            @else
                                <p class="text-gray-900 whitespace-no-wrap">{{ is_string($item->applicants) ? $item->applicants : '' }}</p>
                            @endif
                        </td>
                        
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $item->mouza_name }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                @if($item->acquisition_record_basis === 'SA')
                                    {{ $item->getBengaliValue('land_schedule_sa_plot_no') }}
                                @elseif($item->acquisition_record_basis === 'RS')
                                    {{ $item->getBengaliValue('land_schedule_rs_plot_no') }}
                                @else
                                    {{ $item->getBengaliValue('jl_no') }}
                                @endif
                            </p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right whitespace-nowrap">
                            <div class="flex space-x-2">
                                <a href="{{ route('compensation.preview', $item->id) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    প্রিভিউ
                                </a>
                                <a href="{{ route('compensation.edit', $item->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    সম্পাদনা করুন
                                </a>
                                @if($item->status === 'pending')
                                <button onclick="openKanungoOpinionModal({{ $item->id }})" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    কানুনগো/সার্ভেয়ারের মতামত
                                </button>
                                <button onclick="openOrderModal({{ $item->id }})" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    আদেশ
                                </button>
                                @else
                                <span class="bg-green-100 text-green-800 font-bold py-2 px-4 rounded text-sm">
                                    নিষ্পত্তিকৃত
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-10">
                            <p class="text-gray-600">কোনো তথ্য পাওয়া যায়নি।</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            {{ $compensations->links() }}
        </div>
    </div>

    <!-- Kanungo Opinion Modal -->
    <div id="kanungoOpinionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">কানুনগো/সার্ভেয়ারের মতামত</h3>
                    <button onclick="closeKanungoOpinionModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="kanungoOpinionForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">মালিকানার ধারাবাহিকতা আছে কিনা<span class="text-red-500">*</span></label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="kanungo_opinion[has_ownership_continuity]" value="yes" class="mr-2">
                                    <span>হ্যাঁ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="kanungo_opinion[has_ownership_continuity]" value="no" class="mr-2">
                                    <span>না</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">মতামতঃ</label>
                            <textarea name="kanungo_opinion[opinion_details]" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="আপনার মতামত লিখুন..."></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeKanungoOpinionModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            বাতিল
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            জমা দিন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Modal -->
    <div id="orderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">আদেশ</h3>
                    <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="orderForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">আদেশ স্বাক্ষরের তারিখ<span class="text-red-500">*</span></label>
                            <input type="text" name="order_signature_date" placeholder="দিন/মাস/বছর" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">স্বাক্ষরকারী কর্মকর্তার নাম<span class="text-red-500">*</span></label>
                            <input type="text" name="signing_officer_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="কর্মকর্তার নাম লিখুন..." required>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeOrderModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            বাতিল
                        </button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            আদেশ নিষ্পত্তিকৃত করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openKanungoOpinionModal(compensationId) {
            const modal = document.getElementById('kanungoOpinionModal');
            const form = document.getElementById('kanungoOpinionForm');
            
            // Set the form action
            form.action = `/compensation/${compensationId}/kanungo-opinion`;
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Load existing data if available
            fetch(`/compensation/${compensationId}/kanungo-opinion`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.kanungo_opinion) {
                        const opinion = data.kanungo_opinion;
                        
                        // Set radio button
                        const radio = document.querySelector(`input[name="kanungo_opinion[has_ownership_continuity]"][value="${opinion.has_ownership_continuity}"]`);
                        if (radio) radio.checked = true;
                        
                        // Set textarea
                        const textarea = document.querySelector('textarea[name="kanungo_opinion[opinion_details]"]');
                        if (textarea) textarea.value = opinion.opinion_details || '';
                    }
                })
                .catch(error => {
                    console.error('Error loading kanungo opinion:', error);
                });
        }
        
        function closeKanungoOpinionModal() {
            const modal = document.getElementById('kanungoOpinionModal');
            modal.classList.add('hidden');
            
            // Reset form
            const form = document.getElementById('kanungoOpinionForm');
            form.reset();
        }
        
        // Handle form submission
        document.getElementById('kanungoOpinionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(form.action, {
                method: 'POST', // Change to POST and use _method field
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    showMessage(data.message, 'success');
                    
                    // Close modal immediately
                    closeKanungoOpinionModal();
                    
                    // Reload page after a short delay to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showMessage('কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
            });
        });
        
        // Order Modal Functions
        function openOrderModal(compensationId) {
            const modal = document.getElementById('orderModal');
            const form = document.getElementById('orderForm');
            
            // Set the form action
            form.action = `/compensation/${compensationId}/order`;
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Load existing data if available
            fetch(`/compensation/${compensationId}/order`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.order_signature_date) {
                        document.querySelector('input[name="order_signature_date"]').value = data.order_signature_date;
                    }
                    if (data.signing_officer_name) {
                        document.querySelector('input[name="signing_officer_name"]').value = data.signing_officer_name;
                    }
                })
                .catch(error => {
                    console.error('Error loading order data:', error);
                });
        }
        
        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.add('hidden');
            
            // Reset form
            const form = document.getElementById('orderForm');
            form.reset();
        }
        
        // Handle order form submission
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    showMessage(data.message, 'success');
                    
                    // Close modal immediately
                    closeOrderModal();
                    
                    // Reload page after a short delay to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showMessage('কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
            });
        });
        
        function showMessage(message, type) {
            // Remove existing message
            const existingMessage = document.querySelector('.message-alert');
            if (existingMessage) {
                existingMessage.remove();
            }
            
            // Create new message
            const messageDiv = document.createElement('div');
            messageDiv.className = `message-alert fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            messageDiv.textContent = message;
            
            document.body.appendChild(messageDiv);
            
            // Remove message after 3 seconds
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }
        
        // Close modal when clicking outside
        document.getElementById('kanungoOpinionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeKanungoOpinionModal();
            }
        });
    </script>
@endsection