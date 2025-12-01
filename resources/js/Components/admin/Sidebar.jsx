import React from "react";
import axios from "axios";

const Sidebar = ({ activeMenu, setActiveMenu, isGlass, style, setIsGlass }) => {
    const handleLogout = async () => {
        try {
            await axios.post("/logout");
            window.location.href = "/login";
        } catch (error) {
            console.error("Logout failed", error);
        }
    };

    const menus = [
        {
            name: "Dashboard",
            icon: "M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z",
        },
        {
            name: "Pelanggan",
            icon: "M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2",
        },
        {
            name: "Layanan",
            icon: "M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z",
        },
        {
            name: "Keuangan",
            icon: "M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
        },
    ];

    return (
        <div
            className={`w-20 md:w-64 fixed h-full z-50 transition-colors duration-500 flex flex-col justify-between ${style.sidebar}`}
        >
            <div>
                <div className="h-20 flex items-center justify-center md:justify-start md:px-8 border-b border-white/10">
                    <span className="hidden md:block font-bold text-xl">
                        SCA Admin
                    </span>
                </div>
                <nav className="mt-8 space-y-2 px-2">
                    {menus.map((menu) => (
                        <button
                            key={menu.name}
                            onClick={() =>
                                setActiveMenu(menu.name.toLowerCase())
                            }
                            className={`w-full flex items-center p-3 rounded-xl transition-all 
                            ${
                                activeMenu === menu.name.toLowerCase()
                                    ? style.activeMenu
                                    : `text-slate-400 hover:bg-white/10`
                            }`}
                        >
                            <svg
                                className="w-5 h-5 mr-3"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d={menu.icon}
                                ></path>
                            </svg>
                            <span className="hidden md:block text-sm">
                                {menu.name}
                            </span>
                        </button>
                    ))}
                </nav>
            </div>

            <div className="p-4 space-y-3 border-t border-white/5">
                <button
                    onClick={() => setIsGlass(!isGlass)}
                    className={`w-full py-3 rounded-xl text-xs font-bold border transition-all flex justify-center items-center gap-2
                    ${
                        isGlass
                            ? "bg-white/10 border-white/20 text-white"
                            : "bg-white border-slate-200 text-slate-600 shadow-sm"
                    }`}
                >
                    {isGlass ? "Glass" : "Normal"}
                </button>

                <button
                    onClick={handleLogout}
                    className="w-full py-3 rounded-xl text-xs font-bold bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all flex justify-center items-center gap-2 border border-red-500/20"
                >
                    <svg
                        className="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                        ></path>
                    </svg>
                    <span className="hidden md:inline">Logout</span>
                </button>
            </div>
        </div>
    );
};

export default Sidebar;
