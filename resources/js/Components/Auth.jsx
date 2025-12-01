import React, { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";

// Animated wave component
const AnimatedWave = ({ position, color, delay }) => (
    <div
        className={`absolute left-0 w-full overflow-hidden leading-none z-0 ${
            position === "top" ? "top-0 rotate-180" : "bottom-0"
        }`}
    >
        <svg
            className="relative block w-[200%] h-[150px] md:h-[300px]"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1200 120"
            preserveAspectRatio="none"
        >
            <motion.path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                fill={color}
                animate={{ x: ["0%", "-50%"] }}
                transition={{
                    duration: 20,
                    repeat: Infinity,
                    ease: "linear",
                    delay,
                }}
            />
        </svg>
    </div>
);

const Auth = () => {
    const [isRegister, setIsRegister] = useState(false);
    const [formData, setFormData] = useState({
        name: "",
        email: "",
        password: "",
    });

    const handleChange = (e) =>
        setFormData({ ...formData, [e.target.name]: e.target.value });

    return (
        <div className="min-h-screen w-full relative bg-white flex items-center justify-center overflow-hidden font-sans">
            <AnimatedWave position="top" color="#1e3a8a" delay={0} />

            <div className="absolute top-0 left-0 w-full h-[300px] opacity-50 z-0">
                <svg
                    className="relative block w-[200%] h-full"
                    viewBox="0 0 1200 120"
                    preserveAspectRatio="none"
                >
                    <motion.path
                        d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
                        fill="#dbeafe"
                        animate={{ x: ["-50%", "0%"] }}
                        transition={{
                            duration: 25,
                            repeat: Infinity,
                            ease: "linear",
                        }}
                    />
                </svg>
            </div>

            <AnimatedWave position="bottom" color="#eff6ff" delay={0} />

            <div className="relative z-10 w-full max-w-md p-6">
                <motion.div
                    initial={{ scale: 0 }}
                    animate={{ scale: 1 }}
                    className="w-24 h-24 bg-white rounded-full shadow-xl mx-auto mb-6 flex items-center justify-center relative z-20"
                >
                    <div className="text-4xl">🧺</div>
                    <motion.div
                        className="absolute inset-0 rounded-full border-4 border-blue-100"
                        animate={{ scale: [1, 1.2, 1], opacity: [1, 0, 1] }}
                        transition={{ duration: 2, repeat: Infinity }}
                    />
                </motion.div>

                <motion.div
                    layout
                    className="bg-white/90 backdrop-blur-lg rounded-[40px] shadow-2xl p-8 md:p-10 border border-white"
                >
                    <div className="text-center mb-8">
                        <AnimatePresence mode="wait">
                            <motion.h2
                                key={isRegister ? "reg-title" : "log-title"}
                                initial={{ y: 20, opacity: 0 }}
                                animate={{ y: 0, opacity: 1 }}
                                exit={{ y: -20, opacity: 0 }}
                                className="text-3xl font-bold text-primary"
                            >
                                {isRegister
                                    ? "Buat Akun Baru"
                                    : "Selamat Datang"}
                            </motion.h2>
                        </AnimatePresence>
                        <p className="text-xs text-slate-400 mt-1">
                            SCA Laundry App
                        </p>
                    </div>

                    <div className="relative overflow-hidden">
                        <AnimatePresence mode="wait" initial={false}>
                            <motion.form
                                key={isRegister ? "register" : "login"}
                                initial={{
                                    x: isRegister ? 100 : -100,
                                    opacity: 0,
                                }}
                                animate={{ x: 0, opacity: 1 }}
                                exit={{
                                    x: isRegister ? -100 : 100,
                                    opacity: 0,
                                }}
                                transition={{
                                    duration: 0.4,
                                    ease: "easeInOut",
                                }}
                                className="space-y-5"
                            >
                                {isRegister && (
                                    <div className="space-y-1">
                                        <label className="text-xs font-bold text-slate-600 ml-2">
                                            Nama Lengkap
                                        </label>
                                        <input
                                            type="text"
                                            name="name"
                                            value={formData.name}
                                            onChange={handleChange}
                                            className="w-full bg-inputgray px-6 py-3.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all"
                                            placeholder="Nama Kamu"
                                        />
                                    </div>
                                )}

                                <div className="space-y-1">
                                    <label className="text-xs font-bold text-slate-600 ml-2">
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        value={formData.email}
                                        onChange={handleChange}
                                        className="w-full bg-inputgray px-6 py-3.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all"
                                        placeholder="email@contoh.com"
                                    />
                                </div>

                                <div className="space-y-1">
                                    <label className="text-xs font-bold text-slate-600 ml-2">
                                        Password
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        value={formData.password}
                                        onChange={handleChange}
                                        className="w-full bg-inputgray px-6 py-3.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all"
                                        placeholder="••••••••"
                                    />
                                </div>

                                {!isRegister && (
                                    <div className="text-right">
                                        <a
                                            href="#"
                                            className="text-[10px] font-bold text-blue-500 hover:underline"
                                        >
                                            Lupa Password?
                                        </a>
                                    </div>
                                )}

                                <motion.button
                                    whileHover={{ scale: 1.02 }}
                                    whileTap={{ scale: 0.98 }}
                                    className="w-full bg-primary text-white py-4 rounded-xl font-bold text-sm shadow-lg shadow-blue-900/20 mt-4"
                                    type="button"
                                >
                                    {isRegister ? "Daftar Sekarang" : "Masuk"}
                                </motion.button>
                            </motion.form>
                        </AnimatePresence>
                    </div>

                    <div className="mt-8">
                        <div className="relative flex py-2 items-center mb-4">
                            <div className="flex-grow border-t border-slate-200"></div>
                            <span className="flex-shrink mx-4 text-slate-300 text-[10px] uppercase tracking-widest">
                                Atau
                            </span>
                            <div className="flex-grow border-t border-slate-200"></div>
                        </div>
                        <div className="flex justify-center gap-4">
                            <SocialBtn icon="G" />
                            <SocialBtn icon="f" />
                            <SocialBtn icon="" />
                        </div>
                    </div>
                </motion.div>

                <motion.div
                    className="text-center mt-6 relative z-20"
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                >
                    <p className="text-sm text-slate-600">
                        {isRegister ? "Sudah punya akun?" : "Belum punya akun?"}
                        <button
                            onClick={() => setIsRegister(!isRegister)}
                            className="ml-2 font-bold text-primary hover:underline"
                        >
                            {isRegister ? "Login di sini" : "Daftar di sini"}
                        </button>
                    </p>
                </motion.div>
            </div>

            <div className="absolute bottom-0 left-0 w-full z-0">
                <svg
                    className="relative block w-[200%] h-[100px]"
                    viewBox="0 0 1200 120"
                    preserveAspectRatio="none"
                >
                    <motion.path
                        d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
                        fill="#1e3a8a"
                        animate={{ x: ["-50%", "0%"] }}
                        transition={{
                            duration: 15,
                            repeat: Infinity,
                            ease: "linear",
                        }}
                    />
                </svg>
            </div>
        </div>
    );
};

const SocialBtn = ({ icon }) => (
    <motion.button
        whileHover={{ y: -3, backgroundColor: "#eff6ff" }}
        className="w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 font-bold text-lg bg-white shadow-sm"
    >
        {icon}
    </motion.button>
);

export default Auth;
