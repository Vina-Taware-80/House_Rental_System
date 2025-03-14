// Show and Hide Sections
function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}

// Show Add Property Form
function showPropertyForm() {
    document.getElementById('property-form').classList.remove('hidden');
}

// Hide Add Property Form
function hidePropertyForm() {
    document.getElementById('property-form').classList.add('hidden');
}

// ✅ Save Property to Database
function saveProperty() {
    const formData = new FormData();

    formData.append('action', 'add');
    formData.append('title', document.getElementById('title').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('location', document.getElementById('location').value);
    formData.append('price', document.getElementById('price').value);
    formData.append('contact', document.getElementById('contact').value);
    formData.append('image', document.getElementById('image').files[0]);
    formData.append('status', document.getElementById('status').value);

    fetch('manage_property.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Property Added Successfully!');
            location.reload();
        }
    });
}

// ✅ Delete Property
function deleteProperty(propertyId) {
    if (confirm('Are you sure you want to delete this property?')) {
        fetch('manage_property.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=delete&id=${propertyId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'deleted') {
                alert('Property Deleted Successfully!');
                location.reload();
            }
        });
    }
}

// ✅ Approve Booking
function approveBooking(bookingId) {
    fetch('manage_property.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=approve&id=${bookingId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'approved') {
            alert('Booking Approved Successfully!');
            location.reload();
        }
    });
}

// ✅ Cancel Booking
function cancelBooking(bookingId) {
    fetch('manage_property.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=cancel&id=${bookingId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'cancelled') {
            alert('Booking Cancelled Successfully!');
            location.reload();
        }
    });
}
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active');
    });

    // Show the selected section
    const activeSection = document.getElementById(sectionId);
    if (activeSection) {
        activeSection.classList.add('active');
    }
}

function showPropertyForm() {
    const form = document.getElementById('property-form');
    form.classList.toggle('active');
}

function hidePropertyForm() {
    const form = document.getElementById('property-form');
    form.classList.remove('active');
}

