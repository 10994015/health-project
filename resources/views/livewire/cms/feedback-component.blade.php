<div class="feedback-component" x-data="{
    exportLoading: false,
    exportExcel(){
        this.exportLoading = true;
        Livewire.dispatch('export');
    }
}" x-on:export-success.window="exportLoading = false">
    <div class="px-4 py-8 mx-auto max-w-7xl">
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-red-400">114年健康體育週 團體衛教講座</h2>
            </div>

            <div class="space-y-6">
                <!-- 工具列 -->
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0">
                    <!-- 左側按鈕群組 -->
                    <div class="inline-flex rounded-md shadow-sm">
                        <select
                            wire:model.live='score'
                            class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                            <option value="">顯示全部</option>
                            <option value="5" class="text-green-700">非常滿意</option>
                            <option value="4" class="text-blue-700">滿意</option>
                            <option value="3" class="text-gray-700">普通</option>
                            <option value="2" class="text-orange-700">不滿意</option>
                            <option value="1" class="text-red-700">非常不滿意</option>
                        </select>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms='search'
                                placeholder="搜尋關鍵字..."
                                class="block w-full py-2 pl-10 pr-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg md:w-96 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                    </div>

                    <!-- 右側控制項 -->
                    <div class="flex items-center space-x-4">
                        <select wire:model.live='limit' class="block w-32 text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">顯示全部</option>
                            <option value="10">顯示10筆</option>
                            <option value="50">顯示50筆</option>
                            <option value="100">顯示100筆</option>
                            <option value="200">顯示200筆</option>
                            <option value="300">顯示300筆</option>
                        </select>
                        <button  @click="exportExcel" :disabled="exportLoading" :class="[exportLoading ? 'cursor-not-allowed' : '' ,'px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500']">
                            <span x-show="!exportLoading" class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>匯出Excel</span>
                            </span>
                            <span x-show="exportLoading" class="flex items-center space-x-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>處理中...</span>
                            </span>
                         </button>
                    </div>
                </div>

                <!-- 表格區域 -->
                <div class="overflow-hidden border border-gray-200 rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200" id="paginated-students">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    學號
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    姓名
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    內容
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    評分
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    想說的話
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    建立時間
                                </th>
                            </tr>
                        </thead>

                        @if($students->count() === 0)
                            <tbody class="bg-white divide-y divide-gray-200" wire:loading.remove wire:target="search, score, limit" >
                                <tr class="transition-colors duration-200 hover:bg-gray-50" >
                                    <th  colspan=7 class="w-full px-6 py-20 text-sm text-gray-900 whitespace-nowrap" >
                                        <div class="flex items-center justify-center min-w-full"  >
                                            <div class="flex flex-col items-center w-full p-4 space-y-3">
                                                <span class="text-sm font-medium text-red-500">查無資料</span>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        @endif
                        <tbody class="bg-white divide-y divide-gray-200" wire:loading.remove wire:target="search, score, limit">
                            @foreach($students as $student)
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $student->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $student->student_id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $student?->game_record?->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="max-w-xs space-y-1">
                                            @for($i=1; $i<=7; $i++)
                                                @if($student->{"question_".$i})
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors duration-200">
                                                        {{$contents['question'.$i]}}
                                                    </span>
                                                @endif
                                            @endfor
                                        </div>
                                     </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($student->score)
                                            @case(5)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                                    非常滿意
                                                </span>
                                                @break
                                            @case(4)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                                    滿意
                                                </span>
                                                @break
                                            @case(3)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">
                                                    普通
                                                </span>
                                                @break
                                            @case(2)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full">
                                                    不滿意
                                                </span>
                                                @break
                                            @case(1)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                                                    非常不滿意
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div class="max-w-xs overflow-hidden text-ellipsis">
                                            {{ $student->comment }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $student->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr class="transition-colors duration-200 hover:bg-gray-50">
                                <td colspan="7" class="w-full min-w-full"  >
                                    <div class="flex items-center justify-center min-w-full py-20" wire:loading  wire:target="search, score, limit" >
                                        <div class="flex flex-col items-center w-full p-4 space-y-3">
                                            <div class="w-8 h-8 border-4 border-blue-200 rounded-full border-t-blue-500 animate-spin"></div>
                                            <span class="text-sm font-medium text-gray-600">載入中...</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
            </div>
            @if(!empty($limit) && $students->count() > 0)
            <div class="my-8">
                {{ $students->links(data: ['scrollTo' => '#paginated-students']) }}
            </div>
            @endif
        </div>
    </div>
 </div>
