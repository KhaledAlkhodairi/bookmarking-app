import React, { useState, useEffect } from "react";
import BookmarkList from "./listLink";
import BookmarkForm from "./create";
import "./styles.css";
export default function App() {
  const [bookmarks, setBookmarks] = useState([]);
  const [isLoaded, setIsLoaded] = useState(false);

  useEffect(() => {
    fetchBookmarks();
  }, []);

  const fetchBookmarks = async () => {
    try {
      const response = await fetch("http://localhost:8000/api/readAll.php");
      const result = await response.json();
      setBookmarks(Array.isArray(result) ? result : []);
      setIsLoaded(true);
    } catch (error) {
      console.error("Error fetching bookmarks", error);
      setIsLoaded(true);
    }
  }

  return (
    <div className="App">
      <BookmarkForm onAddBookmark={fetchBookmarks} />
      <BookmarkList 
        bookmarks={bookmarks} 
        isLoaded={isLoaded} 
        onCrudOperation={fetchBookmarks} 
      />
    </div>
  );
}