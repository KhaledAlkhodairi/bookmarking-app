import React, { useState, useEffect } from "react";
import "./styles.css";

const Bookmark = ({ bookmark, onCrudOperation }) => {
  const [newLink, setNewLink] = useState("");
  const [isUpdated, setIsUpdated] = useState(false);

  const handleDelete = async () => {
    try {
      await fetch("http://localhost:8000/api/delete.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: bookmark.id }),
      });
      setIsUpdated(true);
      onCrudOperation();
    } catch (error) {
      console.log("Error deleting bookmark", error);
    }
  }

  const handleUpdate = async () => {
    const formattedLink = newLink.startsWith('http://') || newLink.startsWith('https://')
      ? newLink
      : `http://${newLink}`;
  
    try {
      await fetch("http://localhost:3000/api/update.php", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: bookmark.id, link: formattedLink }),
      });
      setIsUpdated(true);
      onCrudOperation();
    } catch (error) {
      console.log("Error updating bookmark", error);
    }
  }

  useEffect(() => {
    if (isUpdated) {
      // Reset update state and perform any additional logic if needed
      setIsUpdated(false);
    }
  }, [isUpdated]);

 

  return (
    <div className="bookmark-container">
      <h1 className="bookmark-title">{bookmark.title}</h1>
      <a className="bookmark-link" href={bookmark.link} target="_blank" rel="noopener noreferrer">
        {bookmark.link}
      </a>
      <div className="bookmark-actions">
        <input
          className="bookmark-input"
          type="text"
          placeholder="Enter the New Link"
          value={newLink}
          onChange={(e) => setNewLink(e.target.value)}
        />
        <button className="bookmark-button-delete" onClick={handleDelete}>
          DELETE
        </button>
        <button className="bookmark-button-update" onClick={handleUpdate}>
          UPDATE
        </button>
      </div>
    </div>
  );
};


export default Bookmark;