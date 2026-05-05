
function showTab(tab) {
    document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
    document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
    document.getElementById(tab + '-form').classList.add('active');
    document.getElementById(tab + '-tab').classList.add('active');
}


function validateRegister() {
    const name     = document.getElementById('reg-name')?.value.trim();
    const email    = document.getElementById('reg-email')?.value.trim();
    const password = document.getElementById('reg-password')?.value;
    const confirm  = document.getElementById('reg-confirm')?.value;
    const errors   = [];

    if (!name || name.length < 3)
        errors.push("• Full name must be at least 3 characters.");
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
        errors.push("• Please enter a valid email address.");
    if (!password || password.length < 6)
        errors.push("• Password must be at least 6 characters.");
    if (password !== confirm)
        errors.push("• Passwords do not match.");

    if (errors.length > 0) {
        alert("Please fix the following errors:\n\n" + errors.join("\n"));
        return false;
    }
    return true;
}


function validateLogin() {
    const email    = document.getElementById('login-email')?.value.trim();
    const password = document.getElementById('login-password')?.value;
    const errors   = [];

    if (!email)    errors.push("• Email address is required.");
    if (!password) errors.push("• Password is required.");

    if (errors.length > 0) {
        alert("Please fix the following errors:\n\n" + errors.join("\n"));
        return false;
    }
    return true;
}


function validateBooking() {
    const doctor = document.getElementById('doctor')?.value;
    const date   = document.getElementById('date')?.value;
    const time   = document.getElementById('time')?.value;
    const errors = [];

    if (!doctor)
        errors.push("• Please select a doctor.");

    if (!date) {
        errors.push("• Please choose an appointment date.");
    } else {
        const selected = new Date(date);
        const today    = new Date();
        today.setHours(0, 0, 0, 0);
        if (selected < today)
            errors.push("• Appointment date cannot be in the past.");
    }

    if (!time)
        errors.push("• Please choose an appointment time.");

    if (errors.length > 0) {
        alert("Please fix the following errors:\n\n" + errors.join("\n"));
        return false;
    }
    return true;
}


function confirmDelete(form) {
    if (confirm("Are you sure you want to cancel this appointment?")) {
        form.submit();
    }
    return false;
}
