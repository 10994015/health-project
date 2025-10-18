<div class="lottery-component" x-data="{
    selected: [],
    students: [],
    selectAll: false,
    limit: 1,
    winners: [],
    winnerCounters:0,
    lotteryCounter:0,
    init() {
        Livewire.dispatch('getStudents');
    },
    show() {
        console.log(this.selected);
    },
    colors: ['bg-green-200', 'bg-blue-200', 'bg-yellow-200', 'bg-purple-200'],
    lottery() {
        if (this.selected.length === 0) {
            alert('樣本人數不足');
            return;
        }
        if (this.selected.length < this.limit) {
            alert('樣本人數不足以抽出指定數量的獲獎者');
            return;
        }
        const color = this.colors[this.lotteryCounter % this.colors.length];
        for (let i = 0; i < this.limit; i++) {
            if (this.selected.length === 0) {
                break;
            }
            const randomIndex = Math.floor(Math.random() * this.selected.length);
            const winner = this.selected.splice(randomIndex, 1)[0]; // 從 selected 中移除並獲取獲獎者
            this.winners.push({
                id: this.winnerCounters++,
                student_id: winner,
                bg: color,
            }); // 將獲獎者添加到 winners 中
        }
        this.lotteryCounter++;
    },
    toggleAll() {
        if (this.selectAll) {
            this.selected = this.students.map(student => student.student_id);  // 改為存入 JSON 字符串
        } else {
            this.selected = [];
        }
        this.show();
    },
    getStudentInfo(student_id){
        console.log(this.students);
        const student =  this.students.find(student => student.student_id === student_id);
        return `${student.student_id} - ${student.name} `;
    },
    reset(){
        this.selected = [];
        this.selectAll = false;
        this.winners = [];
        this.winnerCounters = 0;
        this.lotteryCounter = 0;
    },
    refreshStudents(students){
        this.students = [...students[0]];
        this.winners = [];
        this.selectAll = false;
        this.winnerCounters = 0;
        this.lotteryCounter = 0;
    }

}"
x-on:refresh-students.window="refreshStudents($event.detail)"
>
    <div class="px-4 py-8 mx-auto bg-white max-w-7xl">
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-red-400">114年健康體育週 團體衛教講座</h2>
            </div>

            <div class="lottery-block">
                <!-- 左側名單區域 -->
                <div class="w-full">
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h3 class="mb-4 text-lg font-medium text-gray-800">名單資訊</h3>
                        <div class="space-y-4">
                            <!-- 篩選選項 -->
                            <div>
                                <select wire:model.live='timeId' wire:change='refreshStuednts()' class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">全部顯示(符合資格者)</option>
                                    @foreach($selectTimes as $time)
                                        <option value="{{ $time['id'] }}">{{ $time['text'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- 總人數顯示 -->
                            <div class="p-4 rounded-md bg-blue-50">
                                <p class="font-medium text-blue-800">總參與人數：<span class="text-xl">{{ count($students) }}</span> 人</p>
                            </div>
                            <div class="flex items-center justify-center w-full" wire:loading '>
                                <div class="flex flex-col items-center p-4 space-y-3 ">
                                    <div class="w-8 h-8 border-4 border-blue-200 rounded-full border-t-blue-500 animate-spin"></div>
                                    <span class="text-sm font-medium text-gray-600">載入中...</span>
                                </div>
                            </div>
                            <!-- 名單列表 -->
                            <div class="mt-4" wire:loading.remove >
                                <div x-cloak class="flex flex-col items-center justify-center p-8 space-y-2 text-gray-500" x-show="students.length===0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <span class="text-sm">尚無資料</span>
                                </div>
                                <ul x-cloak class="space-y-2 max-h-[400px] overflow-y-auto pr-2" x-show="students.length > 0">
                                    <li class="transition-colors duration-150 bg-blue-200 rounded-md hover:bg-blue-300">
                                        <label class="flex items-center p-2 space-x-3 cursor-pointer">
                                            <input type="checkbox"
                                                x-model="selectAll"
                                                @change="toggleAll()"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="text-sm text-gray-700">
                                                全選
                                            </span>
                                        </label>
                                    </li>
                                    <template x-for="student in students" :key="student.student_id">
                                        <li :class="['transition-colors', 'duration-150', 'rounded-md', 'hover:bg-gray-100',]">
                                            <label class="flex items-center p-2 space-x-3 cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                    x-model="selected"
                                                    :value="student.student_id"
                                                    @change="show()"
                                                >
                                                <span class="text-sm text-gray-700"
                                                    x-text="`${student.student_id} - ${student.name} - ${student.created_at}`">
                                                </span>
                                            </label>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 右側抽獎區域 -->
                <div class="w-full">
                    <div class="p-4 mb-6 rounded-lg bg-gray-50">
                        <h3 class="mb-4 text-lg font-medium text-gray-800">抽獎設定</h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input
                                    type="number"
                                    x-model="limit"
                                    placeholder="請輸入人數"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                >
                            </div>
                            <div class="flex items-center">
                                <button @click="lottery()" class="px-4 py-2 font-bold text-white bg-blue-500 border border-blue-700 rounded hover:bg-blue-700">
                                    抽獎
                                </button>
                            </div>
                            <div class="flex items-center " style="margin-left:auto">
                                <button @click="reset()" class="px-4 py-2 font-bold text-white bg-gray-500 border border-gray-700 rounded hover:bg-gray-700">
                                    重新設定
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50">
                        <h3 class="mb-4 text-lg font-medium text-gray-800">抽獎結果</h3>
                        <ul class="space-y-3 max-h-[400px] overflow-y-auto pr-2">
                            <template x-if="winners.length===0">
                                <li class="p-3 bg-white rounded-md shadow-sm">
                                    <label class="block text-sm text-gray-500">
                                        尚未開獎
                                    </label>
                                </li>
                            </template>
                            <template x-for="winner in winners" :key="winner.id">
                                <ul :class="[winner.bg, 'p-3 rounded-md shadow-sm']">
                                    <li class="">
                                        <label class="block text-sm text-gray-700" x-text="getStudentInfo(winner.student_id)">
                                        </label>
                                    </li>
                                </ul>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white rounded-lg shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b">
                <h3 class="text-lg font-medium text-gray-800">滿意度統計</h3>
                <p class="text-sm text-gray-600">Total：<span class="font-medium text-black">{{ $totalScoreCount }}</span></p>
            </div>
            <div class="mt-4 space-y-3">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">非常滿意</p>
                    <span class="font-medium text-green-600">{{ $veryGoodCount }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">滿意</p>
                    <span class="font-medium text-blue-600">{{ $goodCount }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">普通</p>
                    <span class="font-medium">{{ $normalCount }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">不滿意</p>
                    <span class="font-medium text-orange-600">{{ $badCount }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">非常不滿意</p>
                    <span class="font-medium text-red-600">{{ $veryBadCount }}</span>
                </div>
            </div>
        </div>

     </div>
</div>
