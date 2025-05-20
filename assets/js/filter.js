document.addEventListener("DOMContentLoaded", function () {
    // Lấy tham chiếu đến các select box
    const cinemaSelect = document.getElementById("cinema-select");
    const movieSelect = document.getElementById("movie-select");
    const showtimeSelect = document.getElementById("showtime-select");
    // const dateSelect = document.getElementById("date-select"); // Ví dụ nếu có

    // --- HÀM HỖ TRỢ: Cập nhật giao diện (màu sắc) cho select box ---
    function updateSelectAppearance(selectElement) {
        if (!selectElement) {
            return;
        }
        if (selectElement.value && selectElement.value !== "") {
            selectElement.classList.add('selected-active');
        } else {
            selectElement.classList.remove('selected-active');
        }
    }

    // --- KHỞI TẠO GIAO DIỆN BAN ĐẦU ---
    [cinemaSelect, movieSelect, showtimeSelect /*, dateSelect*/].filter(Boolean).forEach(updateSelectAppearance);

    // --- SỰ KIỆN CHO CINEMA SELECT (Chọn Rạp) ---
    if (cinemaSelect) {
        cinemaSelect.addEventListener("change", function () {
            const cinemaId = this.value;
            updateSelectAppearance(cinemaSelect);

            if (movieSelect) {
                movieSelect.innerHTML = `<option value=""> 2. Chọn phim </option>`;
                movieSelect.disabled = true;
                updateSelectAppearance(movieSelect);
            }
            if (showtimeSelect) {
                showtimeSelect.innerHTML = `<option value=""> 3. Chọn suất chiếu </option>`;
                showtimeSelect.disabled = true;
                updateSelectAppearance(showtimeSelect);
            }
            // Reset dateSelect nếu có

            if (cinemaId) { // Nếu đã chọn rạp (không phải placeholder)
                fetch(`app/controler/get_movies_fast_book.php?cinema_id=${cinemaId}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(data => {
                        data.forEach(movie => {
                            movieSelect.innerHTML += `<option value="${movie.movie_id}">${movie.title}</option>`;
                        });
                        movieSelect.disabled = false;
                        // === THAY ĐỔI MỚI: TỰ ĐỘNG CHUYỂN FOCUS ===
                        if (movieSelect) { // Kiểm tra lại movieSelect tồn tại và được enable
                           movieSelect.focus(); // Chuyển focus đến ô chọn phim
                        }
                        // ========================================
                    })
                    .catch(error => {
                        console.error('Lỗi khi lấy danh sách phim:', error);
                    });
            }
        });
    }

    // --- SỰ KIỆN CHO MOVIE SELECT (Chọn Phim) ---
    if (movieSelect) {
        movieSelect.addEventListener("change", function () {
            const movieId = this.value;
            const cinemaId = cinemaSelect ? cinemaSelect.value : "";
            updateSelectAppearance(movieSelect);

            if (showtimeSelect) {
                showtimeSelect.innerHTML = `<option value=""> 3. Chọn suất chiếu </option>`;
                showtimeSelect.disabled = true;
                updateSelectAppearance(showtimeSelect);
            }
            // Reset dateSelect nếu có

            if (movieId && cinemaId) { // Nếu đã chọn phim (không phải placeholder)
                fetch(`app/controler/get_showtimes_fast_book.php?cinema_id=${cinemaId}&movie_id=${movieId}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(data => {
                        data.forEach(show => {
                            showtimeSelect.innerHTML += `<option value="${show.showtime_id}">${show.start_time}</option>`;
                        });
                        showtimeSelect.disabled = false;
                        // === THAY ĐỔI MỚI: TỰ ĐỘNG CHUYỂN FOCUS ===
                        if (showtimeSelect) { // Kiểm tra lại showtimeSelect tồn tại và được enable
                           showtimeSelect.focus(); // Chuyển focus đến ô chọn suất chiếu
                        }
                        // ========================================
                    })
                    .catch(error => {
                        console.error('Lỗi khi lấy danh sách suất chiếu:', error);
                    });
            }
        });
    }

    // --- SỰ KIỆN CHO SHOWTIME SELECT (Chọn Suất Chiếu) ---
    if (showtimeSelect) {
        showtimeSelect.addEventListener("change", function () {
            updateSelectAppearance(showtimeSelect);
            // Nếu có mục chọn ngày (dateSelect) và nó được enable sau khi chọn suất,
            // bạn có thể thêm dateSelect.focus() ở đây sau khi fetch ngày (nếu có AJAX cho ngày)
        });
    }

    document.getElementById("order-now").addEventListener("click", function (e) {
        e.preventDefault(); // Ngăn chuyển trang nếu có thẻ <a>

        const cinemaId = document.getElementById("cinema-select").value;
        const movieId = document.getElementById("movie-select").value;
        const showtimeId = document.getElementById("showtime-select").value;

        // Kiểm tra đầy đủ các lựa chọn
        if (!cinemaId || !movieId || !showtimeId) {
            return;
        }
        console.log(cinemaId,movieId,showtimeId)

        // Chuyển hướng đến trang chi tiết phim với tham số
        window.location.href = `index.php?page=movie-details&id=${movieId}&cinema_id=${cinemaId}&showtime_id=${showtimeId}`;
    });

    // Tương tự cho dateSelect nếu có
    // if (dateSelect) {
    //     dateSelect.addEventListener("change", function() {
    //         updateSelectAppearance(dateSelect);
    //         // Nếu có select box tiếp theo, focus vào nó sau khi dateSelect được chọn và select tiếp theo được enable
    //     });
    // }
});