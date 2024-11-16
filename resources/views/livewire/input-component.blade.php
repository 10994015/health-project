<div class="input-component">
    <div class="form">
        <form wire:submit.prevent='submit'>
            <input type="number" wire:model.live='student_id' placeholder="請輸入學號" name="student"  id="student" required>
            @error('student_id') <span class="error-message">{{ $message }}</span> @enderror
            <input type="text" wire:model.live='name' placeholder="請輸入姓名" name="name" required id="name">
            @error('name') <span class="error-message">{{ $message }}</span> @enderror
            <div class="Satisfaction">
                <p style="text-align:center;font-size:18px;font-weight: 600;">您對本次活動的滿意度為何?</p>
                <select name="score" wire:model='score'>
                    <option value="5">非常滿意</option>
                    <option value="4">滿意</option>
                    <option value="3">普通</option>
                    <option value="2">不滿意</option>
                    <option value="1">非常不滿意</option>
                </select>
                @error('score') <span class="error-message">{{ $message }}</span> @enderror
                <p style="text-align:center;font-size:18px;font-weight: 600;margin-top:10px">您覺得本次活動學習到?(可複選)</p>
                <label for="q1">
                    <input type="checkbox" id="q1" name="q1" wire:model.live='q1' class="study">瞭解運動對身體的好處及重要性，願意培養運動習慣。
                </label>
                <label for="q2">
                    <input type="checkbox" id="q2" name="q2" wire:model.live='q2' class="study">瞭解含糖飲料對身體的負面影響及多喝白開水的益處。
                </label>
                <label for="q3">
                    <input type="checkbox" id="q3" name="q3" wire:model.live='q3' class="study">飲料紅黃綠燈有助於選擇飲品的判斷。
                </label>
                <label for="q4">
                    <input type="checkbox" id="q4" name="q4" wire:model.live='q4' class="study">我會願意於生活中實踐視力保健及口腔護理。
                </label>
                <label for="q5">
                    <input type="checkbox" id="q5" name="q5" wire:model.live='q5' class="study">瞭解如何照顧及學會傷口處理，降低紅腫熱痛感染的發生。
                </label>
                <label for="q6">
                    <input type="checkbox" id="q6" name="q6" wire:model.live='q6' class="study">我願意將今日所學的健康知識傳遞給身邊的同學與親友。
                </label>
                <label for="q7">
                    <input type="checkbox" id="q7" name="q7" wire:model.live='q7' class="study">我會想主動學習更多相關健康知識。
                </label>
                <textarea name="comment" id="" wire:model.live='comment' placeholder="您對本次活動心得回饋..."></textarea>
            </div>
            <input type="submit" value="完成"  />
        </form>
    </div>

    <style>
        .form{
            background: url({{ asset('images/bg.jpg') }}) no-repeat;
        }
    </style>
</div>
