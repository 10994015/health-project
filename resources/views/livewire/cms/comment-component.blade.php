<div class="comment-component">
    <div class="px-4 py-8 mx-auto max-w-7xl">
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-red-400">113年健康體育週 團體衛教講座</h2>
            </div>

            <div class="space-y-6">
                <!-- 工具列 -->
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0">
                    <div></div>
                    <!-- 右側控制項 -->
                    <div class="flex items-center space-x-4">

                        <button wire:click="export" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>匯出Excel</span>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- 表格區域 -->
                <div class="max-w-3xl mx-auto overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                    <table class="w-full divide-y divide-gray-200" id="paginated-students">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <th class="w-2/3 px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs font-bold text-blue-600 bg-blue-100 rounded-full">1</span>
                                        瞭解運動對身體的好處及重要性，願意培養運動習慣。
                                    </div>
                                </th>
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">
                                    {{ $comments->question_1 }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="w-2/3 px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs font-bold text-blue-600 bg-blue-100 rounded-full">2</span>
                                        瞭解含糖飲料對身體的負面影響及多喝白開水的益處。
                                    </div>
                                </th>
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">
                                    {{ $comments->question_2 }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="w-2/3 px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs font-bold text-blue-600 bg-blue-100 rounded-full">3</span>
                                        飲料紅黃綠燈有助於選擇飲品的判斷。
                                    </div>
                                </th>
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">
                                    {{ $comments->question_3 }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="w-2/3 px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs font-bold text-blue-600 bg-blue-100 rounded-full">4</span>
                                        我會願意於生活中實踐視力保健及口腔護理。
                                    </div>
                                </th>
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">
                                    {{ $comments->question_4 }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="w-2/3 px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs font-bold text-blue-600 bg-blue-100 rounded-full">5</span>
                                        瞭解如何照顧及學會傷口處理，降低紅腫熱痛感染的發生。
                                    </div>
                                </th>
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">
                                    {{ $comments->question_5 }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="w-2/3 px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs font-bold text-blue-600 bg-blue-100 rounded-full">6</span>
                                        我願意將今日所學的健康知識傳遞給身邊的同學與親友。
                                    </div>
                                </th>
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">
                                    {{ $comments->question_6 }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="w-2/3 px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs font-bold text-blue-600 bg-blue-100 rounded-full">7</span>
                                        我會想主動學習更多相關健康知識。
                                    </div>
                                </th>
                                <td class="px-4 py-3 text-sm text-gray-800 whitespace-nowrap">
                                    {{ $comments->question_7 }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
    </div>
 </div>
