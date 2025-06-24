<link rel="stylesheet" href="/../dashboard/style/content_upload.css">

<div class="upload-page">
    <main class="upload-main">
        <h1>Content Upload</h1>
        <div class="upload-card">
            <h2>Upload Content</h2>

            <div class="drop-zone">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <p>Drag & Drop files here</p>
                <span>or click to browse</span>
            </div>

            <div class="input-grid">
                <input type="text" placeholder="Title">
                <input type="text" placeholder="Tags (comma separated)">
            </div>
            <textarea placeholder="Description" rows="6"></textarea>
            
            <div class="options-section">
                <div class="thumbnail-uploader">
                    <i class="fa-solid fa-image"></i>
                    <span>Thumbnail</span>
                </div>
                <div class="upload-options">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="private">
                        <span class="checkmark"></span>
                        Private
                    </label>
                    <label class="custom-checkbox">
                        <input type="checkbox" name="schedule">
                        <span class="checkmark"></span>
                        Schedule
                    </label>
                     <label class="custom-checkbox">
                        <input type="checkbox" name="cross-post">
                        <span class="checkmark"></span>
                        Cross-Post
                    </label>
                </div>
            </div>

            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 40%;"></div>
                </div>
            </div>

            <button class="upload-now-btn">Upload Now</button>
        </div>
    </main>

    <aside class="previous-uploads-sidebar">
        <div class="sidebar-header">
            <h3>Previous Uploads</h3>
            <button class="refresh-btn"><i class="fa-solid fa-rotate-right"></i></button>
        </div>
        <ul class="upload-list">
            <li class="upload-item">
                <img src="https://picsum.photos/seed/upload1/100/60" alt="Valorant Highlights">
                <div class="item-info">
                    <h4>Valorant Highlights #24</h4>
                    <p>2 days ago • 12k views</p>
                </div>
                <button class="more-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            </li>
            <li class="upload-item">
                <img src="https://picsum.photos/seed/upload2/100/60" alt="Funny Fails">
                <div class="item-info">
                    <h4>Funny Fails Compilation</h4>
                    <p>4 days ago • 860 views</p>
                </div>
                <button class="more-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            </li>
            <li class="upload-item">
                <img src="https://picsum.photos/seed/upload3/100/60" alt="RPG Tutorial">
                <div class="item-info">
                    <h4>RPG Tutorial Part 5</h4>
                    <p>1 week ago • 2.4k views</p>
                </div>
                <button class="more-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            </li>
        </ul>
    </aside>
</div>