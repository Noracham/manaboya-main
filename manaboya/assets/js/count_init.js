// pCountは解いた問題数です。
// cCountは正答数です。


function setCookie(name, value, days) {
    const expirationDate = new Date();
    expirationDate.setTime(expirationDate.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + expirationDate.toUTCString();
    document.cookie = name + "=" + value + "; " + expires + "; path=/";
}


function updateCookie(name, value, days) {
    setCookie(name, value, days);
}



function checkCookie(name) {
    const cookies = document.cookie.split("; ");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].split("=");
        if (cookie[0] === name) {
            return true;
        }
    }
    return false;
}

function initCookie(name) {
    const hasCookie = checkCookie(name);
    if (hasCookie) {
        console.log("Cookie exists");
        updateCookie(name, "0", 7);
    } else {
        console.log("Cookie does not exist");
        setCookie(name, "0", 7);
    }
}
function deleteCookie(cookieName) {
    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

deleteCookie("startTime");

initCookie("pCount");
initCookie("cCount");