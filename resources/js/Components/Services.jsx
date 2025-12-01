import React from "react";
import { motion } from "framer-motion";
import SectionWrapper from "./SectionWrapper";

const Services = ({ isGlass, servicesData }) => {
    const getImage = (name) => {
        if (name.toLowerCase().includes("sepatu"))
            return "https://images.unsplash.com/photo-1603808033192-082d6919d3e1?q=80&w=500&auto=format&fit=crop";
        if (name.toLowerCase().includes("express"))
            return "https://images.unsplash.com/photo-1517677208171-0bc12dd9743c?q=80&w=500&auto=format&fit=crop";
        return "https://images.unsplash.com/photo-1582735689369-4fe89db7114c?q=80&w=500&auto=format&fit=crop"; // Default Baju
    };

    return (
        <SectionWrapper
            id="layanan"
            className={isGlass ? "" : "bg-secondary"}
            isGlass={isGlass}
        >
            <div className="text-center mb-12 relative z-10">
                <h2
                    className={`text-3xl font-bold transition-colors duration-500 ${
                        isGlass ? "text-white" : "text-slate-800"
                    }`}
                >
                    Layanan Kami
                </h2>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl relative z-10">
                {servicesData.map((item, index) => (
                    <motion.div
                        key={item.id}
                        whileHover={{ y: -10 }}
                        className={`p-6 rounded-[35px] text-center flex flex-col items-center border relative group transition-all duration-500 overflow-hidden
                        ${
                            isGlass
                                ? "bg-white/10 backdrop-blur-md border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)]"
                                : "bg-cardblue border-white/50 shadow-sm hover:shadow-md"
                        }`}
                    >
                        <div className="w-full h-48 rounded-3xl mb-6 overflow-hidden relative shadow-sm">
                            <div className="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-all z-10"></div>
                            <img
                                src={getImage(item.name)}
                                alt={item.name}
                                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            />
                        </div>

                        <h3
                            className={`text-xl font-bold mb-1 transition-colors duration-500 ${
                                isGlass ? "text-white" : "text-blue-800"
                            }`}
                        >
                            {item.name}
                        </h3>

                        <p
                            className={`text-sm font-bold mb-6 transition-colors duration-500 ${
                                isGlass ? "text-cyan-300" : "text-blue-600"
                            }`}
                        >
                            Rp {item.price.toLocaleString()} {item.unit}
                        </p>

                        <button
                            className={`px-8 py-3 rounded-xl text-xs font-bold mt-auto w-full transition duration-500 
                            ${
                                isGlass
                                    ? "bg-cyan-600 text-white hover:bg-cyan-500"
                                    : "bg-primary text-white hover:bg-blue-900"
                            }`}
                        >
                            Pesan Sekarang
                        </button>
                    </motion.div>
                ))}
            </div>
        </SectionWrapper>
    );
};

export default Services;
