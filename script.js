async function registerUser(event) {
    event.preventDefault();
    const username = document.getElementById('reg-username').value;
    const email = document.getElementById('reg-email').value;
    const password = document.getElementById('reg-password').value;

    const userData = `Username: ${username}\nEmail: ${email}\nPassword: ${password}\n`;

    try {
        const directoryHandle = await window.showDirectoryPicker();
        const fileHandle = await directoryHandle.getFileHandle('Registered.txt', { create: true });
        const writable = await fileHandle.createWritable();
        
        await writable.write(userData);
        await writable.close();

        alert('Registration successful! Redirecting to login...');
        showLogin();
    } catch (error) {
        console.error('Error saving file:', error);
        alert('Failed to save your registration. Please Go to direct Login page. Here,  UserName: admin@gmail.com   Password:123 ');
    }
}

const defaultEmail = "admin@gmail.com";
const defaultPassword = "123";

async function loginUser(event) {
    event.preventDefault();
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    if (email === defaultEmail && password === defaultPassword) {
        alert('Login successful! Redirecting to event management page...');
        window.location.href = 'index.html';
    } else {
        alert('Invalid credentials. Please try again.');
    }
}
