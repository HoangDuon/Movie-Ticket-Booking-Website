document.addEventListener("DOMContentLoaded", function () {
    const cinemaSelect = document.getElementById("cinema-select");
    const movieSelect = document.getElementById("movie-select");
    const showtimeSelect = document.getElementById("showtime-select");

    cinemaSelect.addEventListener("change", function () {
        const cinemaId = this.value;

        movieSelect.innerHTML = `<option value="">-- Chọn phim --</option>`;
        showtimeSelect.innerHTML = `<option value="">-- Chọn suất chiếu --</option>`;
        movieSelect.disabled = true;
        showtimeSelect.disabled = true;


        if (cinemaId) {
            fetch(`app/controler/get_movies_fast_book.php?cinema_id=${cinemaId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(movie => {
                        movieSelect.innerHTML += `<option value="${movie.movie_id}">${movie.title}</option>`;
                    });
                    movieSelect.disabled = false;
                });
        }
    });

    movieSelect.addEventListener("change", function () {
        const movieId = this.value;
        const cinemaId = cinemaSelect.value;

        showtimeSelect.innerHTML = `<option value="">-- Chọn suất chiếu --</option>`;
        showtimeSelect.disabled = true;

        if (movieId && cinemaId) {
            fetch(`app/controler/get_showtimes_fast_book.php?cinema_id=${cinemaId}&movie_id=${movieId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(show => {
                        showtimeSelect.innerHTML += `<option value="${show.showtime_id}">${show.start_time}</option>`;
                    });
                    showtimeSelect.disabled = false;
                });
        }
    });

    
});
