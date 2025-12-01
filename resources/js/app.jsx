import "./bootstrap";
import React from "react";
import ReactDOM from "react-dom/client";

import UserPage from "./Components/Userpage";
import LoginPage from "./Components/Login";
import AdminPage from "./Components/Admin";

//  USER PAGE
const userRoot = document.getElementById("root-user");
if (userRoot) {
    ReactDOM.createRoot(userRoot).render(
        <React.StrictMode>
            <UserPage />
        </React.StrictMode>
    );
}

//  LOGIN PAGE
const loginRoot = document.getElementById("root-login");
if (loginRoot) {
    ReactDOM.createRoot(loginRoot).render(
        <React.StrictMode>
            <LoginPage />
        </React.StrictMode>
    );
}

//  ADMIN PAGE
const adminRoot = document.getElementById("root-admin");
if (adminRoot) {
    ReactDOM.createRoot(adminRoot).render(
        <React.StrictMode>
            <AdminPage />
        </React.StrictMode>
    );
}
