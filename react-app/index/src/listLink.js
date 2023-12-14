import React from "react";
import Bookmark from "./Bookmark";
import "./styles.css";



const BookmarkList = ({ bookmarks, isLoaded, onCrudOperation }) => {
  if (!isLoaded) {
    return <p>Loading...</p>;
  }

  if (bookmarks.length === 0) {
    return <h1>Add a new bookmark :3</h1>;
  }

  return (
    <div>
      {bookmarks.map((bookmark, index) => (
        <Bookmark key={index} bookmark={bookmark} onCrudOperation={onCrudOperation} />
      ))}
    </div>
  );
}

export default BookmarkList;