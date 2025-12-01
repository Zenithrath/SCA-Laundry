import React from "react";
import axios from "axios";

const Navbar = ({ isGlass, isLoggedIn, userName }) => {
    const handleLogout = async (e) => {
        e.preventDefault();
        try {
            await axios.post("/logout");
            window.location.href = "/login";
        } catch (error) {
            console.error("Logout error", error);
        }
    };

    return (
        <nav
            className={`fixed top-0 left-0 right-0 flex justify-between items-center px-6 md:px-16 py-5 z-50 backdrop-blur-md border-b transition-all duration-500
            ${
                isGlass
                    ? "bg-slate-900/50 border-white/10 text-white"
                    : "bg-secondary/80 border-white/20 text-slate-600"
            }`}
        >
            <div
                className={`text-2xl font-bold tracking-tight ${
                    isGlass ? "text-cyan-400" : "text-blue-700"
                }`}
            >
                SCA Laundry
            </div>

            <div
                className={`hidden md:flex space-x-8 text-sm font-medium ${
                    isGlass ? "text-blue-100" : "text-slate-600"
                }`}
            >
                {["Home", "Layanan", "Tracking", "Dashboard"].map((item) => (
                    <a
                        key={item}
                        href={`#${item.toLowerCase()}`}
                        className="hover:text-blue-500 transition"
                    >
                        {item}
                    </a>
                ))}
            </div>

            <div className="flex items-center gap-3">
                {isLoggedIn ? (
                    <>
                        <div
                            className={`hidden md:block text-right mr-2 ${
                                isGlass ? "text-white" : "text-slate-800"
                            }`}
                        >
                            <p className="text-xs font-bold">Hi, {userName}</p>
                        </div>

                        <button
                            onClick={handleLogout}
                            className={`px-4 py-2 rounded-lg text-xs font-bold border transition-all
                            ${
                                isGlass
                                    ? "bg-red-500/20 text-red-300 border-red-500/50"
                                    : "bg-white text-red-500 border-red-200"
                            }`}
                        >
                            Logout
                        </button>
                    </>
                ) : (
                    <a
                        href="/login"
                        className={`px-6 py-2.5 rounded-lg text-sm font-bold transition border
                        ${
                            isGlass
                                ? "bg-white/5 text-white"
                                : "bg-white text-slate-600 border-slate-200"
                        }`}
                    >
                        Login
                    </a>
                )}

                <a
                    href="#order"
                    className="px-6 py-2.5 rounded-lg text-sm font-bold bg-blue-600 text-white shadow-lg"
                >
                    Pesan
                </a>
            </div>
        </nav>
    );
};

export default Navbar;
