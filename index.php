<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Event</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #6C63FF;
        --secondary: #FF6584;
        --bg1: #e3f2fd;
        --bg2: #fce4ec;
        --card-bg: rgba(255, 255, 255, 0.9);
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, var(--bg1), var(--bg2));
        margin: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        overflow-x: hidden;
    }
    .container {
        display: flex;
        gap: 20px;
        max-width: 1100px;
        width: 100%;
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        backdrop-filter: blur(12px);
        padding: 30px;
        animation: fadeIn 0.8s ease-in-out;
    }
    form {
        flex: 1;
    }
    h1 {
        color: var(--primary);
        text-align: center;
        margin-bottom: 20px;
    }
    .input-group {
        margin-bottom: 20px;
    }
    .input-group label {
        font-weight: 600;
        display: block;
        margin-bottom: 6px;
    }
    .input-group input, .input-group textarea, .input-group select {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        outline: none;
        transition: border 0.3s, box-shadow 0.3s;
    }
    .input-group input:focus, .input-group textarea:focus, .input-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 8px rgba(108, 99, 255, 0.4);
    }
    button {
        width: 100%;
        padding: 12px;
        background: var(--primary);
        border: none;
        color: white;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }
    button:hover {
        background: var(--secondary);
    }
    .preview {
        flex: 1;
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        text-align: center;
    }
    .preview img {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .preview h2 {
        color: var(--primary);
        margin-bottom: 10px;
    }
    .share-btn {
        margin-top: 15px;
        background: var(--secondary);
    }
    /* Popup */
    .popup {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--primary);
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        animation: fadeInOut 3s forwards;
    }
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }
    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-20px); }
        20% { opacity: 1; transform: translateY(0); }
        80% { opacity: 1; }
        100% { opacity: 0; transform: translateY(-20px); }
    }
</style>
</head>
<body>

<div class="container">
    <form id="eventForm" action="create-event.php" method="post" enctype="multipart/form-data">
        <h1>🎉 Create Your Event</h1>
        <div class="input-group">
            <label for="banner">Event Banner</label>
            <input type="file" id="banner" name="banner" accept="image/*">
        </div>
        <div class="input-group">
            <label for="title">Event Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="input-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div class="input-group">
            <label for="date">Event Date</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div class="input-group">
            <label for="time">Event Time</label>
            <input type="time" id="time" name="time" required>
        </div>
        <div class="input-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location">
        </div>
        <div class="input-group">
            <label for="themeColor">Theme Color</label>
            <input type="color" id="themeColor" name="themeColor" value="#6C63FF">
        </div>
        <button type="submit">Create Event</button>
    </form>

    <div class="preview" id="eventPreview">
        <img id="prevBanner" src="https://via.placeholder.com/600x200?text=Event+Banner">
        <h2 id="prevTitle">Event Title</h2>
        <p id="prevDescription">Event description will appear here...</p>
        <p><strong>Date:</strong> <span id="prevDate">—</span></p>
        <p><strong>Time:</strong> <span id="prevTime">—</span></p>
        <p><strong>Location:</strong> <span id="prevLocation">—</span></p>
        <button class="share-btn" type="button" onclick="shareEvent()">🔗 Share Preview</button>
    </div>
</div>

<div class="popup" id="popupMsg">✅ Event Created Successfully!</div>

<script>
const form = document.getElementById('eventForm');
const popup = document.getElementById('popupMsg');

// Live preview updates
document.querySelectorAll('#eventForm input, #eventForm textarea').forEach(el => {
    el.addEventListener('input', updatePreview);
});
document.getElementById('banner').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        document.getElementById('prevBanner').src = URL.createObjectURL(file);
    }
});

function updatePreview() {
    document.getElementById('prevTitle').textContent = document.getElementById('title').value || 'Event Title';
    document.getElementById('prevDescription').textContent = document.getElementById('description').value || 'Event description will appear here...';
    let dateVal = document.getElementById('date').value;
    document.getElementById('prevDate').textContent = dateVal ? new Date(dateVal).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '—';
    document.getElementById('prevTime').textContent = document.getElementById('time').value || '—';
    document.getElementById('prevLocation').textContent = document.getElementById('location').value || '—';
    document.querySelector('.preview').style.borderColor = document.getElementById('themeColor').value;
}

// ...existing code...

// Share preview
function shareEvent() {
    const link = window.location.href;
    navigator.clipboard.writeText(link).then(() => {
        alert("Event preview link copied to clipboard!");
    });
}
</script>

</body>
</html>
