<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Contact Us</h1>

        <div class="shadow container bg-white mt-5 rounded p-5 text-dark">
            <h2>AIGPS Software House</h2>
            <hr class="mb-4">

            <div class="container row">
                <div class="col-12 col-md-6 border-end">
                    <div class="text-start">
                        <h5> Our Emails </h5>
                        <div class="ms-2">
                            <div>
                                <a href="mailto:info@aigps.ml"> info@aigps.ml </a>
                            </div>
                            <div>
                                <a href="mailto:contact@aigps.ml"> contact@aigps.ml </a>
                            </div>
                        </div>
                    </div>

                    <div class="text-start mt-5">
                        <h5> Our Numbers </h5>
                        <div class="ms-2">
                            <div>
                                <a href="mailto:info@aigps.ml"> info@aigps.ml </a>
                            </div>
                            <div>
                                <a href="mailto:contact@aigps.ml"> contact@aigps.ml </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3455.5268123249007!2d31.309183415424524!3d29.99302608190114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145839202cd65b27%3A0x5bee403e7f57345c!2sModern%20University%20for%20Technology%20%26%20Information!5e0!3m2!1sen!2seg!4v1647614214306!5m2!1sen!2seg" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <h5 class="mt-5 mt-md-0"> Send us a message </h5>
                    <form action="/contact" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>

                        <div class="text-center mt-3">
                            <button style="width: 150px;" type="submit" class="btn btn-success">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
