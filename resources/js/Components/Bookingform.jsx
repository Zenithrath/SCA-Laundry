import React, { useState, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import SectionWrapper from "./SectionWrapper";
import axios from "axios";

const BookingForm = ({ isGlass, servicesData = [], user }) => {
    const [step, setStep] = useState(1);
    const [loading, setLoading] = useState(false);

    const [form, setForm] = useState({
        service_id: "",
        service_name: "",
        service_price: 0,
        weight: "",
        notes: "",
        address: "",
        landmark: "",
        date: "",
        time: "",
        name: "",
        phone: "",
        email: "",
    });

    useEffect(() => {
        if (user) {
            setForm((f) => ({
                ...f,
                name: user.name || "",
                email: user.email || "",
                phone: user.phone || "",
            }));
        }
    }, [user]);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const selectService = (svc) => {
        setForm({
            ...form,
            service_id: svc.id,
            service_name: svc.name,
            service_price: svc.price,
        });
    };

    const calculateTotal = () => {
        const weight = parseFloat(form.weight) || 0;
        const subtotal = form.service_price * weight;
        const jemput = 5000;
        const antar = 5000;
        return { subtotal, jemput, antar, total: subtotal + jemput + antar };
    };

    const handleSubmit = async () => {
        if (!form.service_id || !form.weight || !form.address || !form.date) {
            alert("Mohon lengkapi data pesanan.");
            return;
        }

        setLoading(true);
        try {
            await axios.post("/api/order/store", {
                service_id: form.service_id,
                weight: form.weight,
                pickup_address: form.address,
                pickup_date: form.date,
                pickup_time: form.time,
                name: form.name,
                phone: form.phone,
            });
            alert("Pesanan Berhasil Dibuat!");
            window.location.reload();
        } catch (error) {
            console.error(error);
            if (error.response?.status === 401) {
                alert("Silakan Login terlebih dahulu.");
                window.location.href = "/login";
            } else {
                alert("Gagal membuat pesanan. Periksa inputan.");
            }
        } finally {
            setLoading(false);
        }
    };

    const inputStyle = isGlass
        ? "w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-cyan-400 placeholder-white/40"
        : "w-full bg-[#E5E5E5] border-none rounded-lg px-4 py-3 text-sm text-slate-700 outline-none focus:ring-2 focus:ring-blue-300 placeholder-slate-400";

    const labelStyle = `block text-xs font-bold mb-2 ${
        isGlass ? "text-blue-200" : "text-slate-700"
    }`;

    return (
        <SectionWrapper
            id="order"
            className={isGlass ? "" : "bg-blue-50/50"}
            isGlass={isGlass}
        >
            <div className="text-center mb-8 relative z-10">
                <h2
                    className={`text-3xl font-bold transition-colors ${
                        isGlass ? "text-white" : "text-slate-800"
                    }`}
                >
                    Pesan Laundry Online
                </h2>
                <p
                    className={`text-sm mt-2 ${
                        isGlass ? "text-blue-200" : "text-slate-500"
                    }`}
                >
                    Isi form di bawah untuk memesan layanan laundry
                </p>
            </div>

            <div
                className={`rounded-[30px] p-6 md:p-10 w-full max-w-4xl border transition-all duration-500 relative z-10 min-h-[500px] flex flex-col
                ${
                    isGlass
                        ? "bg-white/10 backdrop-blur-xl border-white/20 shadow-lg text-white"
                        : "bg-white shadow-xl border-white text-slate-800"
                }`}
            >
                <h3 className="text-center text-xl font-bold mb-1">
                    Form Pemesanan
                </h3>
                <p
                    className={`text-center text-xs mb-8 ${
                        isGlass ? "text-blue-200" : "text-slate-400"
                    }`}
                >
                    Isi form di bawah untuk memesan layanan laundry
                </p>

                <div
                    className={`flex justify-between p-1.5 rounded-full mb-8 w-full max-w-3xl mx-auto overflow-x-auto
                    ${isGlass ? "bg-white/10" : "bg-[#F3F4F6]"}`}
                >
                    {["Layanan", "Penjemputan", "Data Diri", "Pembayaran"].map(
                        (label, idx) => (
                            <button
                                key={idx}
                                onClick={() => setStep(idx + 1)}
                                className={`flex-1 py-2 px-2 rounded-full text-[11px] md:text-xs font-bold transition-all duration-300 whitespace-nowrap mx-1
                            ${
                                step === idx + 1
                                    ? isGlass
                                        ? "bg-cyan-600 text-white shadow-lg"
                                        : "bg-white text-slate-800 shadow-sm"
                                    : isGlass
                                    ? "text-white/50 hover:text-white"
                                    : "text-slate-400 hover:text-slate-600"
                            }`}
                            >
                                {label}
                            </button>
                        )
                    )}
                </div>

                <div className="flex-1 relative">
                    <AnimatePresence mode="wait">
                        {step === 1 && (
                            <motion.div
                                key="step1"
                                initial={{ opacity: 0, x: 20 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -20 }}
                                className="space-y-6"
                            >
                                <p className={labelStyle}>
                                    Pilih Jenis Layanan :
                                </p>
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    {servicesData.map((svc) => (
                                        <div
                                            key={svc.id}
                                            onClick={() => selectService(svc)}
                                            className={`p-5 rounded-2xl text-center cursor-pointer border-2 transition-all
                                            ${
                                                form.service_id === svc.id
                                                    ? isGlass
                                                        ? "bg-cyan-500/20 border-cyan-400"
                                                        : "bg-blue-50 border-blue-200 shadow-md"
                                                    : isGlass
                                                    ? "bg-white/5 border-transparent hover:bg-white/10"
                                                    : "bg-[#F3F8FF] border-transparent hover:bg-blue-50"
                                            }`}
                                        >
                                            <h4 className="font-bold text-sm">
                                                {svc.name}
                                            </h4>
                                            <p
                                                className={`text-xs font-bold my-1 ${
                                                    isGlass
                                                        ? "text-cyan-300"
                                                        : "text-slate-600"
                                                }`}
                                            >
                                                Rp {svc.price.toLocaleString()}
                                                /kg
                                            </p>
                                        </div>
                                    ))}
                                </div>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label className={labelStyle}>
                                            Estimasi Berat (Kg) :
                                        </label>
                                        <input
                                            type="number"
                                            name="weight"
                                            value={form.weight}
                                            onChange={handleChange}
                                            className={inputStyle}
                                            placeholder="Contoh: 3"
                                        />
                                    </div>
                                    <div>
                                        <label className={labelStyle}>
                                            Catatan Khusus :
                                        </label>
                                        <input
                                            type="text"
                                            name="notes"
                                            value={form.notes}
                                            onChange={handleChange}
                                            className={inputStyle}
                                            placeholder="Contoh: Jangan disetrika lipat"
                                        />
                                    </div>
                                </div>
                            </motion.div>
                        )}

                        {step === 2 && (
                            <motion.div
                                key="step2"
                                initial={{ opacity: 0, x: 20 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -20 }}
                                className="grid grid-cols-1 md:grid-cols-2 gap-8"
                            >
                                <div className="space-y-4">
                                    <div>
                                        <label className={labelStyle}>
                                            Alamat Penjemputan :
                                        </label>
                                        <textarea
                                            name="address"
                                            rows="3"
                                            value={form.address}
                                            onChange={handleChange}
                                            className={`${inputStyle} resize-none`}
                                            placeholder="Alamat lengkap..."
                                        ></textarea>
                                    </div>
                                    <div>
                                        <label className={labelStyle}>
                                            Patokan :
                                        </label>
                                        <input
                                            type="text"
                                            name="landmark"
                                            value={form.landmark}
                                            onChange={handleChange}
                                            className={inputStyle}
                                            placeholder="Pagar hitam / Depan masjid"
                                        />
                                    </div>
                                </div>
                                <div className="space-y-4">
                                    <div>
                                        <label className={labelStyle}>
                                            Waktu Penjemputan :
                                        </label>
                                        <input
                                            type="date"
                                            name="date"
                                            value={form.date}
                                            onChange={handleChange}
                                            className={inputStyle}
                                        />
                                    </div>
                                    <div>
                                        <label className={labelStyle}>
                                            Jam :
                                        </label>
                                        <div className="space-y-2">
                                            {[
                                                "Pagi (08.00 - 12.00)",
                                                "Siang (13.00 - 17.00)",
                                            ].map((timeSlot) => (
                                                <label
                                                    key={timeSlot}
                                                    className={`flex items-center px-4 py-3 rounded-lg cursor-pointer transition ${
                                                        isGlass
                                                            ? "bg-white/10 hover:bg-white/20"
                                                            : "bg-[#E5E5E5] hover:bg-gray-300"
                                                    }`}
                                                >
                                                    <input
                                                        type="radio"
                                                        name="time"
                                                        value={timeSlot}
                                                        checked={
                                                            form.time ===
                                                            timeSlot
                                                        }
                                                        onChange={handleChange}
                                                        className="accent-blue-600 mr-3 w-4 h-4"
                                                    />
                                                    <span className="text-xs font-medium">
                                                        {timeSlot}
                                                    </span>
                                                </label>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            </motion.div>
                        )}

                        {step === 3 && (
                            <motion.div
                                key="step3"
                                initial={{ opacity: 0, x: 20 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -20 }}
                                className="space-y-5 max-w-2xl mx-auto pt-4"
                            >
                                <div>
                                    <label className={labelStyle}>Nama :</label>
                                    <input
                                        type="text"
                                        name="name"
                                        value={form.name}
                                        onChange={handleChange}
                                        className={inputStyle}
                                    />
                                </div>
                                <div>
                                    <label className={labelStyle}>
                                        Nomor HP :
                                    </label>
                                    <input
                                        type="tel"
                                        name="phone"
                                        value={form.phone}
                                        onChange={handleChange}
                                        className={inputStyle}
                                    />
                                </div>
                                <div>
                                    <label className={labelStyle}>
                                        Email :
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        value={form.email}
                                        onChange={handleChange}
                                        className={inputStyle}
                                    />
                                </div>
                            </motion.div>
                        )}

                        {step === 4 && (
                            <motion.div
                                key="step4"
                                initial={{ opacity: 0, x: 20 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -20 }}
                            >
                                <h4
                                    className={`text-sm font-bold mb-4 ${
                                        isGlass
                                            ? "text-white"
                                            : "text-slate-700"
                                    }`}
                                >
                                    Ringkasan Pesanan
                                </h4>

                                <div
                                    className={`rounded-lg p-6 space-y-3 mb-6 ${
                                        isGlass ? "bg-white/10" : "bg-[#E5E5E5]"
                                    }`}
                                >
                                    <div
                                        className={`flex justify-between text-xs ${
                                            isGlass
                                                ? "text-blue-100"
                                                : "text-slate-700"
                                        }`}
                                    >
                                        <span>
                                            {form.service_name || "Layanan"} (
                                            {form.weight || 0} kg)
                                        </span>
                                        <span>
                                            Rp{" "}
                                            {(
                                                (form.service_price || 0) *
                                                (form.weight || 0)
                                            ).toLocaleString()}
                                        </span>
                                    </div>
                                    <div
                                        className={`flex justify-between text-xs ${
                                            isGlass
                                                ? "text-blue-100"
                                                : "text-slate-700"
                                        }`}
                                    >
                                        <span>Biaya Penjemputan</span>
                                        <span>Rp 5.000</span>
                                    </div>
                                    <div
                                        className={`flex justify-between text-xs pb-3 border-b ${
                                            isGlass
                                                ? "text-blue-100 border-white/20"
                                                : "text-slate-700 border-slate-400"
                                        }`}
                                    >
                                        <span>Biaya Pengantaran</span>
                                        <span>Rp 5.000</span>
                                    </div>
                                    <div className="flex justify-between text-sm font-bold pt-1">
                                        <span
                                            className={
                                                isGlass
                                                    ? "text-white"
                                                    : "text-slate-900"
                                            }
                                        >
                                            Total
                                        </span>
                                        <span className="text-[#4A90E2]">
                                            Rp{" "}
                                            {calculateTotal().total.toLocaleString()}
                                        </span>
                                    </div>
                                </div>

                                <div className="flex justify-end mt-8">
                                    <button
                                        onClick={handleSubmit}
                                        disabled={loading}
                                        className={`px-8 py-3 rounded-lg text-sm font-bold transition shadow-lg
                                        ${
                                            isGlass
                                                ? "bg-cyan-600 text-white hover:bg-cyan-500"
                                                : "bg-[#E5E5E5] text-slate-600 hover:bg-gray-300"
                                        }`}
                                        style={{
                                            backgroundColor: isGlass
                                                ? ""
                                                : "#D1D5DB",
                                        }}
                                    >
                                        {loading
                                            ? "Memproses..."
                                            : "Konfirmasi Pesanan"}
                                    </button>
                                </div>
                            </motion.div>
                        )}
                    </AnimatePresence>
                </div>

                {step < 4 && (
                    <div className="flex justify-between mt-8 pt-4 border-t border-gray-200/10">
                        <button
                            onClick={() => step > 1 && setStep(step - 1)}
                            className={`text-xs font-bold ${
                                step === 1 ? "invisible" : ""
                            } ${
                                isGlass
                                    ? "text-white/50 hover:text-white"
                                    : "text-slate-400 hover:text-slate-600"
                            }`}
                        >
                            &larr; Kembali
                        </button>
                        <button
                            onClick={() => setStep(step + 1)}
                            className={`px-8 py-3 rounded-lg text-xs font-bold transition shadow-lg
                            ${
                                isGlass
                                    ? "bg-cyan-600 text-white"
                                    : "bg-[#1e3a8a] text-white hover:bg-blue-900"
                            }`}
                        >
                            Lanjut
                        </button>
                    </div>
                )}
            </div>
        </SectionWrapper>
    );
};

export default BookingForm;
