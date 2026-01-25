document.addEventListener("DOMContentLoaded", function () {
    // -----------------------------
    // Button Hover Animations (Moved to CSS for better performance)
    // -----------------------------
    // We only keep the loading behavior here if needed
    function handleBtnLoading(form) {
        const btn = form.querySelector(
            'button[type="submit"], input[type="submit"]'
        );
        if (!btn || btn.classList.contains('no-loading')) return;

        // تحديد النص بناءً على الـ ID
        let loadingText = btn.id === "send-otp-btn" ? "Sending..." : "Processing...";

        // التعطيل في الـ Tick الجاية عشان الـ Submit يلحق يخرج
        setTimeout(() => {
            // Only change text if it doesn't have complex HTML or if it's an input
            if (btn.tagName === "INPUT") {
                btn.value = loadingText;
            } else if (btn.children.length === 0) {
                btn.innerText = loadingText;
            }

            btn.disabled = true;
            btn.classList.add('btn-disabled-loading');
        }, 0);
    }

    // 2. تطبيق الكود على كل الفورمات
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function () {
            handleBtnLoading(form);
        });

        // انيميشن ظهور الفورم
        form.style.opacity = 0;
        form.style.transform = "translateY(20px)";
        form.style.transition = "0.6s ease";
        setTimeout(() => {
            form.style.opacity = 1;
            form.style.transform = "translateY(0)";
        }, 100);
    });

    // -----------------------------
    // Password show/hide toggle
    // -----------------------------
    const passwordFields = document.querySelectorAll('input[type="password"]');

    passwordFields.forEach((pwd) => {
        const wrapper = document.createElement("div");
        wrapper.style.position = "relative";
        pwd.parentNode.insertBefore(wrapper, pwd);
        wrapper.appendChild(pwd);

        const toggle = document.createElement("span");
        toggle.textContent = "👀";
        toggle.style.position = "absolute";
        toggle.style.right = "10px";
        toggle.style.top = "43%";
        toggle.style.transform = "translateY(-50%)";
        toggle.style.cursor = "pointer";
        toggle.style.userSelect = "none";
        toggle.style.fontSize = "14px";
        wrapper.appendChild(toggle);

        toggle.addEventListener("click", (e) => {
            e.preventDefault();
            const isPwd = pwd.type === "password";
            pwd.type = isPwd ? "text" : "password";
            toggle.textContent = isPwd ? "🙈" : "👀";
        });
    });

    // 4. كود العداد (Countdown) لو الزرار معطل عند التحميل
    const otpBtn = document.getElementById("send-otp-btn");
    if (otpBtn && otpBtn.disabled) {
        let match = otpBtn.innerText.match(/\d+/);
        if (match) {
            let seconds = parseInt(match[0]);
            let interval = setInterval(() => {
                seconds--;
                if (seconds <= 0) {
                    otpBtn.disabled = false;
                    otpBtn.innerText = "Send Code";
                    otpBtn.style.opacity = "1";
                    otpBtn.style.cursor = "pointer";
                    clearInterval(interval);
                } else {
                    otpBtn.innerText = `Wait ${seconds}s`;
                }
            }, 1000);
        }
    }

    // 5. الانيميشن بتاع الزراير والـ Inputs (Focus/Blur)
    const inputs = document.querySelectorAll(
        'input[type="text"], input[type="password"], input[type="email"]'
    );
    inputs.forEach((input) => {
        input.addEventListener(
            "focus",
            () => (input.style.borderColor = "#6366f1")
        );
        input.addEventListener(
            "blur",
            () => (input.style.borderColor = "#374151")
        );
    });
    // -----------------------------
    // Remember me checkbox fancy toggle
    // -----------------------------
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach((cb) => {
        cb.addEventListener("change", () => {
            if (cb.checked) {
                cb.nextElementSibling.style.color = "rgb(218, 216, 216)";
            } else {
                cb.nextElementSibling.style.color = "#f9fafb";
            }
        });
    });
    // -----------------------------
    // Helpers
    // -----------------------------
    function createMessage(text, type = "error") {
        const msg = document.createElement("div");
        msg.textContent = text;
        msg.classList.add("js-message", type);
        msg.style.padding = "10px";
        msg.style.borderRadius = "8px";
        msg.style.marginTop = "5px";
        msg.style.fontSize = "13px";
        msg.style.textAlign = "center";
        msg.style.color = type === "error" ? "#b81414" : "#000000ff";
        msg.style.background =
            type === "error" ? "rgba(255,0,0,0.1)" : "rgba(0, 0, 0, 0.1)";
        return msg;
    }

    function removeOldMessages(form) {
        const old = form.querySelectorAll(".js-message");
        old.forEach((m) => m.remove());
    }
});

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const output = document.getElementById("preview");
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

document.addEventListener("DOMContentLoaded", function () {
    const toast = document.getElementById("toast-success");

    if (toast) {
        // Wait 4 seconds, then fade out
        setTimeout(() => {
            toast.classList.add("fade-out");

            // Remove from DOM after transition finishes
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 4000);
    }
});

function togglesidebar() {
    const sidebar = document.getElementById("mysidebar");
    const overlay = document.getElementById("myoverlay");

    // تبديل الكلاس فقط
    sidebar.classList.toggle("active");
    if (overlay) overlay.classList.toggle("active");
}

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("theme-toggle");
    const html = document.documentElement;
    const currentuserid =
        typeof window.userid !== "undefined" ? window.userid : "guest";
    const storagekey = `theme_user_${currentuserid}`;

    function applytheme(theme) {
        if (theme === "dark") {
            html.classList.add("dark-mode");
            if (btn) btn.innerText = "☀️";
        } else {
            html.classList.remove("dark-mode");
            if (btn) btn.innerText = "🌙";
        }
    }

    // جلب التفضيل المحفوظ وتطبيقه
    applytheme(localStorage.getItem(storagekey));

    if (btn) {
        btn.onclick = () => {
            const isdark = html.classList.contains("dark-mode");
            const newtheme = isdark ? "light" : "dark";
            localStorage.setItem(storagekey, newtheme);
            applytheme(newtheme);
        };
    }
});
