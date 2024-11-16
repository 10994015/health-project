<div x-data="{
    scoreData: {{ json_encode($scoreData) }},
    timeData: {{ json_encode($timeData) }},
    dailyData: {{ json_encode($dailyData) }},
    questionData: {{ json_encode($questionData) }},
    selectedDate: '',
    init() {
        this.renderScoreChart();
        this.filterTimeData();
        this.renderDailyChart();
        this.renderQuestionChart();
        this.selectedDate = this.checkDateInRange();
    },
    checkDateInRange() {
        const today = new Date();
        const startDate = new Date('2024-12-02');
        const endDate = new Date('2024-12-06');

        // 判斷今天是否在範圍內（包含起始與結束日期）
        if (today >= startDate && today <= endDate) {
            const month = today.getMonth() + 1; // 月份是從 0 開始的，所以需要 +1
            const day = today.getDate();
            return `${Number(month)}/${Number(day)}`;
        }
        return ''; // 不在範圍內回傳空字串
    },
    renderScoreChart() {
        var ctx = document.getElementById('scoreChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['非常滿意', '滿意', '普通', '不滿意', '非常不滿意'],
                datasets: [{
                    label: '評分分佈',
                    data: Object.values(this.scoreData),
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.6)',  // 綠色 - 非常滿意
                        'rgba(59, 130, 246, 0.6)', // 藍色 - 滿意
                        'rgba(234, 179, 8, 0.6)',  // 黃色 - 普通
                        'rgba(249, 115, 22, 0.6)', // 橘色 - 不滿意
                        'rgba(239, 68, 68, 0.6)'   // 紅色 - 非常不滿意
                    ],
                    borderColor: [
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(234, 179, 8)',
                        'rgb(249, 115, 22)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                    maxBarThickness: 50
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }

        });
    },
    renderTimeLoading:false,
    renderTimeChart(filteredData) {
        if(this.timeChart){
            this.timeChart.destroy();
        }
        this.renderTimeLoading = true;
        var ctx = document.getElementById('timeChart').getContext('2d');
        this.timeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(filteredData),
                datasets: [{
                    label: '參與人數',
                    data: Object.values(filteredData),
                    backgroundColor: Object.keys(filteredData).map(label =>
                        (label.includes('第一') || label.includes('第二'))
                            ? 'rgba(234, 179, 8, 0.7)'  // 上午時段 - 黃色
                            : 'rgba(34, 197, 94, 0.7)'   // 下午時段 - 綠色
                    ),
                    borderColor: Object.keys(filteredData).map(label =>
                        (label.includes('第一') || label.includes('第二'))
                            ? 'rgb(234, 179, 8)'  // 上午時段
                            : 'rgb(34, 197, 94)'   // 下午時段
                    ),
                    borderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 10,
                    pointStyle: 'circle',
                    pointBackgroundColor: 'white',
                    pointBorderWidth: 2,
                    tension: 0.3,  // 使線條更平滑
                    fill: false,
                    cubicInterpolationMode: 'monotone'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: '時段參與人數分佈',
                        padding: {
                            top: 10,
                            bottom: 30
                        },
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1f2937',
                        bodyColor: '#1f2937',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `參與人數: ${context.raw} 人`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(200, 200, 200, 0.2)',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return value + ' 人';
                            },
                            font: {
                                size: 12
                            },
                            padding: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            font: {
                                size: 12
                            },
                            padding: 10
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                elements: {
                    line: {
                        tension: 0.3
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 20,
                        top: 20,
                        bottom: 10
                    }
                }
            }
         });


        setTimeout(() => {
            this.renderTimeLoading = false;
        }, 1000);
    },
    filterTimeData() {
        // 根據選擇的日期過濾時段數據
        let filteredData = {};
        if (this.selectedDate != '') {
            for (let key in this.timeData) {
                console.log(key.substring(0, 4) ?? '')
                if (key.substring(0, 4).trim() == (this.selectedDate)) {
                    filteredData[key] = this.timeData[key];
                    console.log(filteredData)
                }
            }
        } else {
            filteredData = this.timeData;
        }
        console.log(filteredData)
        // 重新渲染圖表
        this.renderTimeChart(filteredData);
    },
    renderDailyChart() {
        var ctx = document.getElementById('dailyChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(this.dailyData),
                datasets: [{
                    label: '每日參與人數',
                    data: Object.values(this.dailyData),
                    backgroundColor: 'rgba(99, 102, 241, 0.1)', // 淡紫色背景
                    borderColor: 'rgb(99, 102, 241)',          // 紫色線條
                    borderWidth: 2,
                    fill: true,                                // 填充區域
                    tension: 0.4,                              // 平滑曲線
                    pointRadius: 6,                            // 點的大小
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'white',             // 點的背景色
                    pointBorderColor: 'rgb(99, 102, 241)',     // 點的邊框色
                    pointBorderWidth: 2,
                    pointStyle: 'circle'
                }]
            },
         });
    },
    renderQuestionChart() {
        var ctx = document.getElementById('questionChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    '瞭解運動對身體的好處',
                    '瞭解含糖飲料的影響',
                    '飲料紅黃綠燈判斷',
                    '實踐視力與口腔護理',
                    '瞭解傷口處理方式',
                    '願意分享健康知識',
                    '主動學習相關知識'
                ],
                datasets: [{
                    data: Object.values(this.questionData),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',   // 藍色
                        'rgba(16, 185, 129, 0.8)',   // 綠色
                        'rgba(245, 158, 11, 0.8)',   // 橙色
                        'rgba(99, 102, 241, 0.8)',   // 紫色
                        'rgba(236, 72, 153, 0.8)',   // 粉色
                        'rgba(14, 165, 233, 0.8)',   // 天藍色
                        'rgba(168, 85, 247, 0.8)'    // 淺紫色
                    ],
                    borderColor: 'white',
                    borderWidth: 2,
                    hoverBorderColor: 'white',
                    hoverBorderWidth: 3,
                    hoverOffset: 15
                }]
            },
         });
    }
}">
<div class="p-6 space-y-6">
    <div class="p-6 space-y-6">
        <!-- 頂部導航區 -->
        <div class="flex items-center justify-between p-6 bg-white rounded-lg shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">健康體育週儀表板</h1>
                <p class="mt-1 text-sm text-gray-500">113年度衛教講座統計分析</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('cms.lottery') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 rounded-md shadow-sm bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                    </svg>
                    前往抽獎
                </a>
                <a href="{{ route('cms.feedback') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 rounded-md shadow-sm bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    數據統計
                </a>
            </div>
        </div>
        <!-- 統計卡片區 -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-6">
            <div class="p-6 transition-all duration-300 transform rounded-lg shadow-sm bg-gradient-to-br from-white to-gray-50 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 text-blue-600 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">總學生數量</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-700">{{ number_format($totalStudents) }}</p>
                    </div>
                </div>
            </div>

            <!-- 總回饋數量 -->
            <div class="p-6 transition-all duration-300 transform rounded-lg shadow-sm bg-gradient-to-br from-white to-gray-50 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 text-green-600 bg-green-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">總回饋數量</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-700">{{ number_format($totalGivebacks) }}</p>
                    </div>
                </div>
            </div>

            <!-- 平均評分 -->
            <div class="p-6 transition-all duration-300 transform rounded-lg shadow-sm bg-gradient-to-br from-white to-gray-50 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 text-yellow-600 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">平均評分</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-700">{{ number_format($averageScore, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- 遊戲平均時間 -->
            <div class="p-6 transition-all duration-300 transform rounded-lg shadow-sm bg-gradient-to-br from-white to-gray-50 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 text-blue-600 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">遊戲平均時間</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-700">{{ $avgerageGameTimes }}秒</p>
                    </div>
                </div>
            </div>

            <!-- 最長遊戲時間 -->
            <div class="p-6 transition-all duration-300 transform rounded-lg shadow-sm bg-gradient-to-br from-white to-gray-50 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 text-red-600 bg-red-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">最長遊戲時間</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-700">{{ $maxGameTimes }}秒</p>
                    </div>
                </div>
            </div>

            <!-- 最短遊戲時間 -->
            <div class="p-6 transition-all duration-300 transform rounded-lg shadow-sm bg-gradient-to-br from-white to-gray-50 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 text-green-600 bg-green-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">最短遊戲時間</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-700">{{ $minGameTimes }}秒</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-1 ">
            <!-- 時段分佈圖 (滿版) -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">時段分佈統計</h3>
                        <div class="flex items-center space-x-3">
                            <select :disabled="renderTimeLoading" x-model="selectedDate" @change="filterTimeData()" :class="[renderTimeLoading ? 'bg-gray-300 cursor-not-allowed' : '' ,'w-32 px-3 py-2 text-sm  border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500']">
                                <option value="">全部日期</option>
                                <option value="12/2">2024/12/02</option>
                                <option value="12/3">2024/12/03</option>
                                <option value="12/4">2024/12/04</option>
                                <option value="12/5">2024/12/05</option>
                                <option value="12/6">2024/12/06</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex space-x-6">
                        <!-- 左側圖表 -->
                        <div class="flex-1">
                            <div class="relative">
                                <canvas id="timeChart" class="w-full"></canvas>
                            </div>
                        </div>

                        <!-- 右側資訊面板 -->
                        <div class="w-[32rem] space-y-4">
                            <!-- 時段摘要 -->
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="mb-3 text-sm font-medium text-gray-600">時段摘要</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">最熱門時段</span>
                                        <span class="text-sm font-medium text-gray-900">{{$mostPopularTime}}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">最少人數時段</span>
                                        <span class="text-sm font-medium text-gray-900">{{$leastPopularTime}}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">平均每時段人數</span>
                                        <span class="text-sm font-medium text-gray-900">{{$averagePerTime}}人</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 時段分類 -->
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="mb-3 text-sm font-medium text-gray-600">時段分類</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                        <span class="ml-2 text-sm text-gray-600">上午 (08:10-11:50)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        <span class="ml-2 text-sm text-gray-600">下午 (13:10-16:50)</span>
                                    </div>
                                </div>
                            </div>

                           <!-- 時段使用分析 -->
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="mb-3 text-sm font-medium text-gray-600">時段使用分析</h4>
                                <div class="space-y-3">
                                    <!-- 場次完成率 -->
                                    <div class="flex items-center justify-between pb-2">
                                        <span class="text-sm text-gray-500">場次完成率</span>
                                        <span class="text-sm font-medium text-blue-600">{{ round(($finished/($finished+$unfinished))*100, 1) }}%</span>
                                    </div>

                                    <!-- 場次統計 -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="px-3 py-2 rounded-md bg-gray-50">
                                            <div class="text-xs text-gray-500">已完成場次</div>
                                            <div class="mt-1 text-sm font-medium text-green-600">{{ $finished }} 場</div>
                                        </div>
                                        <div class="px-3 py-2 rounded-md bg-gray-50">
                                            <div class="text-xs text-gray-500">剩餘場次</div>
                                            <div class="mt-1 text-sm font-medium text-orange-600">{{ $unfinished }} 場</div>
                                        </div>
                                    </div>

                                    <!-- 目前進行狀態 -->
                                    <div class="flex items-center space-x-2 text-sm">
                                        <span class="flex-shrink-0 w-2 h-2 bg-green-500 rounded-full"></span>
                                        <span class="text-gray-600">目前進行：{{ $currentSession ?? '無進行中場次' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 備註說明 -->
                            <div class="p-4 rounded-lg bg-blue-50">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="ml-2 text-sm text-blue-600">
                                        最後更新時間：{{ $lastUpdateTime }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 其他圖表區域 -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- 評分分佈 -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">評分分佈</h3>
                    <a href="{{ route('cms.feedback') }}" class="px-3 py-1 text-sm text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        詳細資料
                    </a>
                </div>
                <canvas id="scoreChart" class="w-full" style="height: 300px;"></canvas>
            </div>

            <!-- 每日資料數量 -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">每日資料數量</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">2024 12/2 - 12/6</span>
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <canvas id="dailyChart" class="w-full" style="height: 300px;"></canvas>
            </div>

            <!-- 問題回答數量 -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">問題回答數量</h3>
                    <a href="{{ route('cms.comment') }}" class="px-3 py-1 text-sm text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        詳細資料
                    </a>
                </div>
                <canvas id="questionChart" class="w-full" style="height: 300px;"></canvas>
            </div>
        </div>
     </div>
 </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
