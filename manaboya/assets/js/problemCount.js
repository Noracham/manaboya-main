// Cookieの値を取得する関数
function getCookie(name) {
    const cookieName = name + "=";
    const cookies = document.cookie.split(";");

    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i];
        while (cookie.charAt(0) === " ") {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cookieName) === 0) {
            return cookie.substring(cookieName.length, cookie.length);
        }
    }

    return "";
}

// Cookieの値を更新する関数
function updateCookie(name, value, days) {
    const expirationDate = new Date();
    expirationDate.setTime(expirationDate.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + expirationDate.toUTCString();
    document.cookie = name + "=" + value + "; " + expires + "; path=/";
}



// 指定した要素の直後に新しい要素を挿入する関数
function insertAfter(newElement, targetElement) {
    const parent = targetElement.parentNode;

    if (parent.lastChild === targetElement) {
        // targetElementが最後の子要素の場合、新しい要素を直接追加
        parent.appendChild(newElement);
    } else {
        // targetElementの次の兄弟要素を取得し、その前に新しい要素を挿入
        parent.insertBefore(newElement, targetElement.nextSibling);
    }
}

// 問題の正解を取得
const answer = '<?php echo $answer; ?>';
// 解答結果用の要素作成
const newElement = document.createElement("div");
newElement.classList.add('result');



const btnClick = () => {
    let checkValue = '';
    var result;

    // 解いた問題数の値を取得
    const pCountValue = parseInt(getCookie("pCount"));
    console.log("解いた数(更新前):", pCountValue);
    // 解いた問題数の値を更新
    const newpCountValue = toString(pCountValue + 1);
    updateCookie("pCount", newpCountValue, 7);
    console.log("解いた数(更新後):", getCookie("pCount"));

    // 正解した問題数の値を取得
    const cCountValue = parseInt(getCookie("cCount"));
    console.log("正答数(更新前):", cCountValue);

    // どの選択肢を選んだかを取得
    for (let i = 0; i < len; i++) {
        if (question.item(i).checked) {
            checkValue = question.item(i).value;
        }
    }
    // 正誤判定
    if (checkValue === answer) {
        result = 'せいかい';
        const newcCountValue = toString(cCountValue + 1);
        updateCookie("cCount", newcCountValue, 7);
    } else {
        result = 'ふせいかい';
    }
    console.log('選択されているのは ' + checkValue + ' です' + answer);
    console.log("正答数(更新後):", getCookie("cCount"));
    newElement.textContent = result;

    // 挿入する位置(一旦解答ボタンの下にしてる)の要素を取得
    const targetElement = document.getElementById("btn");

    // 新しい要素を指定した要素の直後に挿入
    insertAfter(newElement, targetElement);

}

// 選択肢の数の取得、1つ目の選択肢にチェックを入れておく処理
let question = document.getElementsByName('choice');
let len = question.length;
question[0].checked = true;

// 解答ボタンにクリックイベントを設定
let checkButton = document.getElementById('checkButton');
checkButton.addEventListener('click', btnClick);