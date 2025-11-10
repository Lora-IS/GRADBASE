// استخراج projectID من عنصر مخفي داخل الصفحة
const projectID = document.getElementById('project-id')?.value;
let isBookmarked = false;

// تحميل حالة الحفظ والمراجعات
if (projectID) {
  checkBookmarkStatus(projectID);
  loadReviews(projectID);
}

// مشاركة المشروع
function shareProject() {
  const url = window.location.href;
  if (navigator.share) {
    navigator.share({ title: document.title, url });
  } else if (navigator.clipboard) {
    navigator.clipboard.writeText(url)
      .then(() => alert("🔗 Link copied to clipboard!"))
      .catch(() => alert("❌ Failed to copy link."));
  } else {
    alert("⚠️ Clipboard not supported on this browser.");
  }
}

// عرض أدوات المشاركة
function toggleShareTools() {
  const linkBox = document.getElementById('share-tools');
  const input = document.getElementById('share-link');
  input.value = window.location.href;
  linkBox.style.display = (linkBox.style.display === 'none' || linkBox.style.display === '') ? 'block' : 'none';
}

// نسخ الرابط
function copyLink() {
  const input = document.getElementById('share-link');
  input.select();
  input.setSelectionRange(0, 99999);
  document.execCommand("copy");
  alert("✅ Link copied to clipboard!");
}

// مشاركة أصلية
function nativeShare() {
  const url = window.location.href;
  if (navigator.share) {
    navigator.share({ title: document.title, url });
  } else {
    alert("⚠️ Native sharing is not supported on this device.");
  }
}

// تقييم المشروع
function rate(stars) {
  document.querySelectorAll('.rating-stars span').forEach((star, i) => {
    star.classList.toggle('active', i < stars);
  });

  fetch('../pages/submit_review.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ rating: stars, comment: "", projectID })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("✅ Rating submitted!");
    } else if (data.error === "Already reviewed") {
      alert("⚠️ You have already rated this project.");
    } else {
      alert("❌ Error submitting rating.");
    }
  });
}

// إرسال تعليق
function submitComment() {
  const comment = document.getElementById('comment-text').value.trim();
  if (!comment) return alert("Please write a comment first.");

  fetch('../pages/submit_review.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ rating: 0, comment, projectID })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("💬 Comment submitted!");
      document.getElementById('comment-text').value = '';
      loadReviews(projectID);
    } else if (data.error === "Already reviewed") {
      alert("⚠️ You already submitted a review for this project.");
    } else {
      alert("❌ Error submitting comment.");
    }
  });
}

// حفظ أو إزالة المشروع من المفضلة
function toggleBookmark() {
  const endpoint = isBookmarked
    ? '../pages/remove_bookmark.php'
    : '../pages/add_bookmark.php';

  fetch(endpoint, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      projectID,
      content: 'Bookmark toggle' // محتوى افتراضي
    })
  })
    .then(res => res.text())
    .then(text => {
      try {
        const data = JSON.parse(text);
        if (data.success) {
          isBookmarked = !isBookmarked;
          updateBookmarkIcon();
          showBookmarkStatus(
            isBookmarked
              ? '✅ Project saved to bookmarks'
              : '❌ Bookmark removed'
          );
        } else {
          const msg = data.error
            ? `⚠️ ${data.error}`
            : '⚠️ Error saving bookmark';
          showBookmarkStatus(msg);
        }
      } catch (e) {
        console.error('Bookmark response error:', e, text);
        showBookmarkStatus('⚠️ Invalid server response');
      }
    })
    .catch(err => {
      console.error('Fetch error:', err);
      showBookmarkStatus('⚠️ Network error while saving bookmark');
    });
}


// تحديث أيقونة الحفظ
function updateBookmarkIcon() {
  document.getElementById('bookmark-icon').src = isBookmarked
    ? '../icomoon/bookmark-filled.svg?v=' + Date.now()
    : '../icomoon/bookmark.svg?v=' + Date.now();
}

// التحقق من حالة الحفظ
function checkBookmarkStatus(projectID) {
  const status = document.getElementById('bookmark-status');
  status.textContent = "Checking bookmark status...";
  status.style.opacity = 1;
  status.style.visibility = "visible";

  fetch('../pages/check_bookmark.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ projectID })
  })
  .then(res => res.json())
  .then(data => {
    isBookmarked = data.bookmarked;
    updateBookmarkIcon();
    status.textContent = isBookmarked
      ? "✅ Already bookmarked"
      : "🔖 Not bookmarked yet";

    setTimeout(() => {
      status.style.opacity = 0;
      status.style.visibility = "hidden";
    }, 3000);
  });
}

// عرض حالة الحفظ
function showBookmarkStatus(message) {
  const status = document.getElementById('bookmark-status');
  status.textContent = message;
  status.style.opacity = 1;
  status.style.visibility = "visible";
  setTimeout(() => {
    status.style.opacity = 0;
    status.style.visibility = "hidden";
  }, 3000);
}

// تحميل التعليقات
function loadReviews(projectID) {
  fetch('../pages/get_reviews.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ projectID })
  })
  .then(res => res.text())
  .then(text => {
    try {
      const data = JSON.parse(text);
      const container = document.getElementById('reviews-section');
      container.innerHTML = '';
      data.reviews.forEach(review => {
        const div = document.createElement('div');
        div.className = 'review-box';
        div.innerHTML = `
          <div class="review-content">
            <strong>${review.reviewerName}</strong> - ⭐ ${review.rating}/5<br>
            <p>${review.comments}</p>
            <small>${review.reviewDate}</small>
          </div>
          ${review.canDelete ? `
            <div class="delete-icon" onclick="deleteReview(${review.reviewID})">
              <img src="../icomoon/delete.svg" alt="Delete" width="18" height="18">
            </div>
          ` : ''}
          <hr>
        `;
        container.appendChild(div);
      });
    } catch (e) {
      console.error("JSON parsing error:", e);
    }
  });
}

// حذف تعليق
function deleteReview(reviewID) {
  if (!confirm("Are you sure you want to delete your review?")) return;

  fetch('../pages/delete_review.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ reviewID })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("✅ Review deleted successfully.");
      loadReviews(projectID);
    } else {
      alert("❌ Failed to delete review.");
    }
  });
}

// إظهار/إخفاء التعليقات
function toggleCommentSection() {
  const section = document.getElementById('comment-section');
  section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
}

// زر الرجوع
function goBack() {
  window.history.back();
}
