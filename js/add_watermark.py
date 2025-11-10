import fitz
import sys

def add_watermark(pdf_path):
    doc = fitz.open(pdf_path)
    for page in doc:
        rect = page.rect
        text = "© GRADBASE | Academic Use Only"
        font_size = 12
        text_width = fitz.get_text_length(text, fontsize=font_size)
        x = (rect.width - text_width) / 2
        y = rect.height - 40
        page.insert_text(
            (x, y),
            text,
            fontsize=font_size,
            color=(0.5, 0.5, 0.5),
            overlay=True
        )

    # save changes back to the same file incrementally (required by PyMuPDF)
    doc.save(pdf_path, incremental=True, encryption=fitz.PDF_ENCRYPT_KEEP)
    doc.close()

if __name__ == "__main__":
    if len(sys.argv) == 2:
        add_watermark(sys.argv[1])
