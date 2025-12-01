import React from "react";
import SectionWrapper from "./SectionWrapper";

const Hero = ({ isGlass }) => (
    <SectionWrapper id="home" className="bg-transparent" isGlass={isGlass}>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full max-w-7xl mt-10 relative z-10">
            <div className="space-y-6 text-center md:text-left z-10">
                <h1
                    className={`text-4xl md:text-6xl font-bold leading-tight transition-colors duration-500 ${
                        isGlass ? "text-white" : "text-slate-800"
                    }`}
                >
                    Layanan Laundry <br />
                    <span
                        className={
                            isGlass
                                ? "text-cyan-400 drop-shadow-lg"
                                : "text-blue-500"
                        }
                    >
                        Terpercaya & Cepat
                    </span>
                </h1>
                <p
                    className={`text-sm md:text-base leading-relaxed max-w-lg mx-auto md:mx-0 ${
                        isGlass ? "text-blue-100" : "text-slate-500"
                    }`}
                >
                    Nikmati kemudahan layanan laundry profesional dengan
                    kualitas terbaik. Pakaian bersih, harum, dan siap pakai
                    dalam waktu singkat!
                </p>

                <div className="flex space-x-4 justify-center md:justify-start pt-2">
                    <button
                        className={`px-8 py-3 rounded-xl text-sm font-semibold shadow-xl transition hover:scale-105 ${
                            isGlass
                                ? "bg-cyan-600 text-white border border-cyan-400/30"
                                : "bg-primary text-white"
                        }`}
                    >
                        Pesan Sekarang
                    </button>
                    <button
                        className={`px-8 py-3 rounded-xl text-sm font-semibold shadow-xl transition hover:scale-105 ${
                            isGlass
                                ? "bg-white/10 border border-white/20 text-white backdrop-blur-md"
                                : "bg-slate-700 text-white"
                        }`}
                    >
                        Lihat Layanan
                    </button>
                </div>
            </div>

            <div className="relative flex justify-center">
                <img
                    src="https://images.unsplash.com/photo-1610557892470-55d9e80c0bce?auto=format&fit=crop&w=800&q=80"
                    className={`rounded-[40px] shadow-2xl w-full h-72 md:h-[450px] object-cover z-10 relative transition-all duration-500 ${
                        isGlass ? "opacity-90" : ""
                    }`}
                />

                <div
                    className={`absolute -top-4 -right-4 w-full h-full rounded-[40px] -z-0 transition-colors duration-500 ${
                        isGlass
                            ? "bg-cyan-500/20 border border-white/10"
                            : "bg-blue-200"
                    }`}
                ></div>
            </div>
        </div>
    </SectionWrapper>
);

export default Hero;
