export function Newsletter() {
  return (
    <section className="py-16 bg-[#C9A227]">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 className="text-3xl md:text-4xl font-bold text-[#1A2A5E] mb-4">
          Get Travel Deals in Your Inbox
        </h2>
        <p className="text-[#1A2A5E] mb-8 text-lg">
          Subscribe to receive exclusive offers and the latest travel updates
        </p>

        {/* Email Form */}
        <div className="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
          <input
            type="email"
            placeholder="Enter your email address"
            className="flex-1 px-6 py-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A2A5E]"
          />
          <button className="bg-[#1A2A5E] text-white px-8 py-4 rounded-lg hover:bg-[#0f1a3d] transition-colors font-semibold whitespace-nowrap">
            Subscribe
          </button>
        </div>
      </div>
    </section>
  );
}
