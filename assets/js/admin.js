const allPages = ["dashboard", "users", "movies", "cinemas","concessions","membership","showtime"];

document.querySelectorAll(".menu-item").forEach(item => {
    item.addEventListener("click", function () {
        const page = this.getAttribute("data-page");

        document.querySelectorAll(".menu-item").forEach(i => i.classList.remove("active"));
        this.classList.add("active");

        allPages.forEach(p => {
            document.getElementById("page-" + p).style.display = "none";
        });

        document.getElementById("page-" + page).style.display = "block";
    });
});

function showEditForm(button) {
    document.getElementById('editTitle').value = button.dataset.title;
    document.getElementById('editGenre').value = button.dataset.genre;
    document.getElementById('editDuration').value = button.dataset.duration;
    document.getElementById('editDirector').value = button.dataset.director;
    document.getElementById('editCast').value = button.dataset.cast;
    document.getElementById('editLanguage').value = button.dataset.language;
    document.getElementById('editReleaseDate').value = button.dataset.release;
    document.getElementById('editDescription').value = button.dataset.description;
    document.getElementById('editId').value = button.dataset.id;
  
    // Hiện form nổi
    document.getElementById('editFormPanel').style.display = 'flex';
  }
  
  function hideEditForm() {
    document.getElementById('editFormPanel').style.display = 'none';
}

function showAddForm() {
  document.getElementById('editForm').reset();

  document.getElementById('editId').value = "";

  document.getElementById('editFormPanel').style.display = 'flex';
  }
