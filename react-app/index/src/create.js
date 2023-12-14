import React, { useState } from "react";
import "./styles.css";

const BookmarkForm = ({ onAddBookmark }) => {
  const [bookmarkTitle, setBookmarkTitle] = useState("");
  const [bookmarkLink, setBookmarkLink] = useState("");

  const addBookmark = async () => {
    try {
      await fetch("http://localhost:8000/api/create.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title: bookmarkTitle, link: bookmarkLink }),
      });
      setBookmarkTitle("");
      setBookmarkLink("");
      onAddBookmark();
      alert("New Bookmark Added!");
    } catch (error) {
      console.error("Error adding bookmark", error);
    }
  }

  return (
    <div className="input-container">
      <input
        type="text"
        value={bookmarkTitle}
        onChange={(e) => setBookmarkTitle(e.target.value)}
        placeholder="Enter a bookmark title"
      />
      <input
        type="text"
        value={bookmarkLink}
        onChange={(e) => setBookmarkLink(e.target.value)}
        placeholder="Enter the bookmark link"
      />
      <button onClick={addBookmark}>Insert Link</button>
    </div>
  );
}

export default BookmarkForm;