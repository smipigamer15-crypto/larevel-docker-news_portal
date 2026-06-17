
document.addEventListener('DOMContentLoaded', () => {

    const searchBtn = document.getElementById('searchBtn');
    const wrapper = document.getElementById('searchWrapper');
    const input = wrapper.querySelector('.search-input');

    searchBtn.addEventListener('click', () => {

        wrapper.classList.toggle('active');

        if (wrapper.classList.contains('active')) {
            setTimeout(() => {
                input.focus();
            }, 200);
        }
    });

});


const input = document.getElementById('searchInput');
const results = document.getElementById('searchResults');

input.addEventListener('keyup', async function() {

    const query = this.value.trim();

    if (query.length < 2) {
        results.style.display = 'none';
        return;
    }

    try {

        const response = await fetch(
            `/search/live?q=${encodeURIComponent(query)}`
        );

        const news = await response.json();

        results.innerHTML = '';

        if (news.length === 0) {
            results.style.display = 'none';
            return;
        }

        news.forEach(item => {

            results.innerHTML += `
                <a href="/news/${item.id}" class="search-item">
                    ${item.title}
                </a>
            `;

        });

        results.style.display = 'block';

    } catch(error) {

        console.error(error);

    }

});

document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.popular-card');

    function filterPosts(category) {

        let shown = 0;

        cards.forEach(card => {

            const cardCategory = card.dataset.category;

            const match =
                category === 'all' ||
                cardCategory === category;

            if (match && shown < 4) {
                card.style.display = '';
                shown++;
            } else {
                card.style.display = 'none';
            }

        });
    }

    buttons.forEach(button => {

        button.addEventListener('click', (e) => {

            e.preventDefault();

            buttons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            filterPosts(button.dataset.category);

        });

    });

  
    filterPosts('all');

});




  document.getElementById('saveForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = this;
        const btn = document.getElementById('saveBtn');
        const textSpan = document.getElementById('saveText');
        const icon = btn.querySelector('i');
        
      
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form)
            });
            
            const data = await response.json();
            
            if (data.saved) {
       
                btn.classList.add('saved');
                textSpan.textContent = 'Seved';
                icon.className = 'fa-solid fa-bookmark';
                
                
                showToast('New saved!', 'success');
            } else {
               
                btn.classList.remove('saved');
                textSpan.textContent = 'Seved';
                icon.className = 'fa-regular fa-bookmark';
                
             
                showToast('Article removed from saved items', 'info');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('An error occurred', 'error');
        } finally {
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
        }
    });
    
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <i class="fa-solid ${type === 'success' ? 'fa-check-circle' : type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }


    function deleteComment(commentId) {
    if (confirm('Are you sure you want to delete this comment?')) {
        fetch(`/comment/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showToast('Error deleting', 'error');
            }
        });
    }
}


document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.main-navbar .container');
    const navMenu = document.querySelector('.nav-menu');
    
    if (navbar && navMenu && window.innerWidth <= 768) {
        const menuToggle = document.createElement('button');
        menuToggle.className = 'menu-toggle';
        menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
        
        const logo = document.querySelector('.logo');
        if (logo) {
            logo.insertAdjacentElement('afterend', menuToggle);
        }
        
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('show');
            this.innerHTML = navMenu.classList.contains('show') ? 
                '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });
    }
});

const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');

if (searchBtn && window.innerWidth <= 768) {
    searchBtn.addEventListener('click', function() {
        searchInput.classList.toggle('active');
        if (searchInput.classList.contains('active')) {
            searchInput.focus();
        }
    });
}
