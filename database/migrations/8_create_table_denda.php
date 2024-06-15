<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_denda', function (Blueprint $table) {
            $table->id();
            $table->string('resi_pjmn')->nullable();
            $table->unsignedInteger('denda_yg_dibyr')->nullable();
            $table->unsignedInteger('uang_yg_dibyrkn')->nullable(); 
            $table->enum('status', ['lunas', 'belum lunas'])->nullable()->default('belum lunas'); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('resi_pjmn')->references('resi_pjmn')->on('tbl_peminjaman')->onDelete('cascade');
        });

        DB::unprepared('
            CREATE TRIGGER trg_after_update_peminjaman
            AFTER UPDATE ON tbl_peminjaman
            FOR EACH ROW
            BEGIN
                DECLARE overdue_days INT;
                DECLARE denda_per_hari INT;
                DECLARE total_denda INT;

                SET denda_per_hari = 5000;
                SET overdue_days = DATEDIFF(NEW.return_date, NEW.created_at);

                IF overdue_days > 7 THEN
                    SET total_denda = (overdue_days - 7) * denda_per_hari;

                    INSERT INTO tbl_denda (resi_pjmn, denda_yg_dibyr, uang_yg_dibyrkn, status, created_at, updated_at)
                    VALUES (NEW.resi_pjmn, total_denda, 0, "belum lunas", NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                        denda_yg_dibyr = total_denda,
                        status = "belum lunas",
                        updated_at = NOW();
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_update_peminjaman');
        Schema::dropIfExists('tbl_denda');
    }
};