<div class="bg-[#f5f5f5] flex-1 p-[80px] md:p-[40px_30px] flex flex-col justify-center">
    <h2 class="text-[2.5em] font-semibold text-center text-[#333] mb-[60px]">Welcome back to Maxit</h2>
    <form action="/auth" method="post">
        <div class="mb-[25px]">
            <label for="login" class="block mb-2 font-medium text-[0.95em] text-[#333]">Login</label>
            <input type="text" id="login" name="login" placeholder="Login"
                class="w-full px-5 py-[15px] rounded-[10px] bg-[#ddd] text-[1em] text-[#333] focus:bg-[#ccc] outline-none placeholder:text-[#888]">
        </div>
        <div class="mb-[25px]">
            <label for="password" class="block mb-2 font-medium text-[0.95em] text-[#333]">Password</label>
            <div class="relative">
                <input type="password" id="password" name="password" placeholder="Password"
                    class="w-full px-5 py-[15px] rounded-[10px] bg-[#ddd] text-[1em] text-[#333] focus:bg-[#ccc] outline-none placeholder:text-[#888]">
                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 bg-transparent border-none text-[#888] text-[1.1em] cursor-pointer" onclick="togglePassword()"></button>
            </div>
            <div class="text-right mt-2">
                <a href="#" class="text-[#ff6b00] text-[0.9em] hover:underline">Forgot password?</a>
            </div>
        </div>
        <button type="submit"
            class="w-full py-5 bg-[#ff6b00] text-white rounded-[10px] text-[1.3em] font-semibold mt-[30px] hover:bg-[#e55a00] transition">
            Se connecter
        </button>
        <div class="text-right mt-4 text-[0.9em] text-[#666]">
            No account yet? <a href="#" class="text-[#ff6b00] hover:underline">Sign Up</a>
        </div>
    </form>
</div>