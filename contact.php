<?php require_once __DIR__.'/header.php';?>
<div class="bg-white text-[#9C2007] py-12 px-6">
  <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 items-stretch">
    
    <!-- Image à gauche -->
    <div class="flex">
      <img src="assets/images/contact.png" alt="Contact Eshop"
           class="w-full h-full object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
    </div>
    
    <!-- Formulaire encadré (border top + left uniquement) -->
    <div class="bg-white border-t border-l border-[#9C2007] rounded-lg shadow-lg p-8 flex flex-col justify-center">
      <h2 class="text-3xl font-bold text-[#9C2007] mb-6 text-center">
        Contactez-nous
      </h2>

      <form action="#" method="POST" class="space-y-6">
        <!-- Nom -->
        <div>
          <label for="name" class="block text-gray-700 font-medium mb-2">
            <i class="fa-solid fa-user mr-2 text-[#9C2007]"></i> Nom complet *
          </label>
          <input type="text" id="name" name="name" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9C2007] focus:outline-none">
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-gray-700 font-medium mb-2">
            <i class="fa-solid fa-envelope mr-2 text-[#9C2007]"></i> Adresse email *
          </label>
          <input type="email" id="email" name="email" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9C2007] focus:outline-none">
        </div>

        <!-- Message -->
        <div>
          <label for="message" class="block text-gray-700 font-medium mb-2">
            <i class="fa-solid fa-comment mr-2 text-[#9C2007]"></i> Message *
          </label>
          <textarea id="message" name="message" rows="5" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9C2007] focus:outline-none"></textarea>
        </div>

        <!-- Bouton -->
        <div class="text-center">
          <button type="submit"
            class="bg-[#9C2007] text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-[#7A1906] transition">
            Envoyer mon message
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php require_once __DIR__.'/footer.php';?>
