document.addEventListener('DOMContentLoaded', () => {
    const itemsGrid = document.getElementById('itemsGrid');
    const tabs = document.querySelectorAll('.tab-btn');
    const reportModal = document.getElementById('reportModal');
    const reportBtn = document.getElementById('reportBtn');
    const closeModal = document.querySelector('.close-modal');
    const reportForm = document.getElementById('reportForm');

    // Initial Load
    fetchItems('all');

    // Tab Filtering
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const type = tab.dataset.type;
            fetchItems(type);
        });
    });

    // Fetch Items
    async function fetchItems(type) {
        itemsGrid.innerHTML = '<div class="loading-spinner"><i class="fa-solid fa-circle-notch fa-spin"></i> Loading...</div>';

        try {
            const url = type === 'all' ? 'api/items.php' : `api/items.php?type=${type}`;
            const response = await fetch(url);
            const items = await response.json();

            renderItems(items);
        } catch (error) {
            console.error('Error:', error);
            itemsGrid.innerHTML = '<p style="text-align:center; width:100%;">Failed to load items. Please try again later.</p>';
        }
    }

    // Render Items
    function renderItems(items) {
        itemsGrid.innerHTML = '';

        if (items.length === 0) {
            itemsGrid.innerHTML = '<p style="text-align:center; width:100%; color:var(--text-muted);">No items found in this category.</p>';
            return;
        }

        items.forEach(item => {
            const badgeClass = item.type === 'lost' ? 'badge-lost' : 'badge-found';
            // Use placeholder if no image
            const imageUrl = item.image_path ? item.image_path : 'https://placehold.co/600x400/181b21/38b6ff?text=No+Image';

            const daysAgo = Math.floor((new Date() - new Date(item.created_at)) / (1000 * 60 * 60 * 24));
            const timeString = daysAgo === 0 ? 'Today' : `${daysAgo} days ago`;

            const card = document.createElement('div');
            card.className = 'item-card';
            card.innerHTML = `
                <div class="item-image">
                    <span class="item-badge ${badgeClass}">${item.type}</span>
                    <img src="${imageUrl}" alt="${item.item_name}" loading="lazy">
                </div>
                <div class="item-content">
                    <span class="item-date">${timeString}</span>
                    <h3 class="item-title">${item.item_name}</h3>
                    <p class="item-desc">${item.description}</p>
                    <div class="item-meta">
                        <span><i class="fa-solid fa-location-dot"></i> ${item.location}</span>
                        <!-- <span><i class="fa-solid fa-phone"></i> Contact</span> -->
                        <!-- In a real app we might hide phone until clicked -->
                    </div>
                    <div style="margin-top:15px">
                        <a href="tel:${item.contact_phone}" class="btn btn-primary btn-block" style="text-align:center; font-size:0.9rem;">Contact: ${item.contact_phone}</a>
                    </div>
                </div>
            `;
            itemsGrid.appendChild(card);
        });
    }

    // Modal Logic
    window.openModal = function (type) {
        reportModal.classList.add('active');
        if (type) {
            const radio = document.querySelector(`input[name="display_type"][value="${type}"]`);
            if (radio) {
                radio.checked = true;
                // Trigger change event manually if needed, or just set hidden input
                document.getElementById('reportType').value = type;
            }
        }
    };

    if (reportBtn) {
        reportBtn.addEventListener('click', () => {
            window.openModal('lost'); // Default
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            reportModal.classList.remove('active');
        });
    }

    // Close on outside click
    reportModal.addEventListener('click', (e) => {
        if (e.target === reportModal) {
            reportModal.classList.remove('active');
        }
    });

    // Form Submission
    reportForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitBtn = reportForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerText;
        submitBtn.innerText = 'Submitting...';
        submitBtn.disabled = true;

        const formData = new FormData(reportForm);

        try {
            const response = await fetch('api/items.php', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            let result;
            try {
                result = JSON.parse(text);
            } catch (err) {
                console.error('Non-JSON response from server:', text);
                alert('Server error: ' + (text || 'Empty response — check PHP error log'));
                return;
            }

            if (result.success) {
                alert('Item reported successfully!');
                reportForm.reset();
                reportModal.classList.remove('active');
                fetchItems('all'); // Refresh grid
            } else {
                alert('Error: ' + (result.error || JSON.stringify(result)));
            }
        } catch (error) {
            alert('Something went wrong. Please try again.');
        } finally {
            submitBtn.innerText = originalText;
            submitBtn.disabled = false;
        }
    });

    // Smooth Scroll for Navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});
