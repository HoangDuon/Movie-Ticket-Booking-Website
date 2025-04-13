function loadPage(pageName) {
    const contentDiv = document.getElementById("main-content");

    fetch(`view/${pageName}.php`)
        .then(res => res.text())
        .then(data => {
            contentDiv.innerHTML = data;
        })
        .catch(err => {
            contentDiv.innerHTML = "<p>Không thể tải nội dung.</p>";
            console.error("Lỗi khi tải trang:", err);
        });
}