import React from "react";

const Footer = ({ isGlass }) => (
    <footer
        className={`w-full pt-16 pb-6 px-6 md:px-16 border-t transition-colors duration-500
        ${
            isGlass
                ? "bg-slate-900 border-white/10 text-white"
                : "bg-white border-gray-100 text-slate-800"
        }`}
    >
        <div className="grid grid-cols-1 md:grid-cols-4 gap-10 w-full max-w-7xl mx-auto mb-10">
            <div className="col-span-1 md:col-span-2">
                <h3
                    className={`text-2xl font-bold mb-4 ${
                        isGlass ? "text-cyan-400" : "text-blue-600"
                    }`}
                >
                    SCA Laundry
                </h3>
                <p
                    className={`text-sm leading-relaxed ${
                        isGlass ? "text-blue-200" : "text-slate-500"
                    }`}
                >
                    Solusi laundry premium.
                </p>
            </div>
        </div>
        <div
            className={`border-t w-full text-center pt-8 text-[10px] ${
                isGlass
                    ? "border-white/10 text-white/40"
                    : "border-gray-100 text-slate-400"
            }`}
        >
            © 2024 SCA Laundry.
        </div>
    </footer>
);

export default Footer;
