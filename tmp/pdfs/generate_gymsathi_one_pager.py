from __future__ import annotations

from dataclasses import dataclass
from pathlib import Path
from typing import Iterable

from reportlab.lib import colors
from reportlab.lib.pagesizes import A4
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfgen.canvas import Canvas


@dataclass(frozen=True)
class Column:
    x: float
    y_top: float
    width: float
    y_bottom: float


def _wrap_lines(text: str, font_name: str, font_size: int, max_width: float) -> list[str]:
    words = text.strip().split()
    if not words:
        return [""]

    lines: list[str] = []
    current = words[0]
    for word in words[1:]:
        candidate = f"{current} {word}"
        if pdfmetrics.stringWidth(candidate, font_name, font_size) <= max_width:
            current = candidate
        else:
            lines.append(current)
            current = word
    lines.append(current)
    return lines


def _draw_heading(c: Canvas, col: Column, y: float, title: str) -> float:
    accent = colors.HexColor("#C8F135")
    c.setStrokeColor(accent)
    c.setLineWidth(3)
    c.line(col.x, y + 2, col.x + 10, y + 2)

    c.setFont("Helvetica-Bold", 13)
    c.setFillGray(0.05)
    c.drawString(col.x + 14, y - 4, title)
    return y - 18


def _draw_para(
    c: Canvas,
    col: Column,
    y: float,
    text: str,
    *,
    font_name: str = "Helvetica",
    font_size: int = 11,
    leading: int = 13,
) -> float:
    c.setFont(font_name, font_size)
    c.setFillGray(0.15)
    for line in _wrap_lines(text, font_name, font_size, col.width):
        c.drawString(col.x, y, line)
        y -= leading
    return y


def _draw_bullets(
    c: Canvas,
    col: Column,
    y: float,
    bullets: Iterable[str],
    *,
    font_name: str = "Helvetica",
    font_size: int = 11,
    leading: int = 13,
    bullet_gap: int = 2,
) -> float:
    c.setFont(font_name, font_size)
    c.setFillGray(0.15)
    indent = 10
    bullet_prefix = "- "
    prefix_width = pdfmetrics.stringWidth(bullet_prefix, font_name, font_size)

    for bullet in bullets:
        wrapped = _wrap_lines(bullet, font_name, font_size, col.width - indent)
        if wrapped:
            c.drawString(col.x, y, bullet_prefix)
            c.drawString(col.x + prefix_width, y, wrapped[0])
            y -= leading
            for cont in wrapped[1:]:
                c.drawString(col.x + indent, y, cont)
                y -= leading
        y -= bullet_gap
    return y


def build_pdf(out_path: Path) -> None:
    out_path.parent.mkdir(parents=True, exist_ok=True)

    page_w, page_h = A4
    margin = 36
    gutter = 18

    col_w = (page_w - 2 * margin - gutter) / 2
    y_top = page_h - margin
    y_bottom = margin

    left = Column(x=margin, y_top=y_top, width=col_w, y_bottom=y_bottom)
    right = Column(x=margin + col_w + gutter, y_top=y_top, width=col_w, y_bottom=y_bottom)

    c = Canvas(str(out_path), pagesize=A4)

    # Header
    c.setFillGray(0.05)
    c.setFont("Helvetica-Bold", 24)
    c.drawString(margin, y_top, "GymSathi")

    accent = colors.HexColor("#C8F135")
    c.setStrokeColor(accent)
    c.setLineWidth(2)
    c.line(margin, y_top - 6, margin + 140, y_top - 6)

    c.setFont("Helvetica", 10)
    c.setFillGray(0.28)
    c.drawString(margin, y_top - 22, "One-page repo-based summary (repo evidence only).")
    c.setFont("Helvetica", 9)
    c.setFillGray(0.35)
    c.drawString(
        margin,
        y_top - 36,
        "Stack: Laravel 13, PHP 8.3+, Blade templates, Tailwind via CDN, SQLite (dev).",
    )

    # Divider
    c.setStrokeGray(0.85)
    c.setLineWidth(1)
    c.line(margin, y_top - 44, page_w - margin, y_top - 44)

    # Column separator
    c.setStrokeGray(0.92)
    c.setLineWidth(1)
    c.line(margin + col_w + (gutter / 2), y_bottom, margin + col_w + (gutter / 2), y_top - 54)

    y_left = y_top - 66
    y_right = y_top - 66

    # Left column
    y_left = _draw_heading(c, left, y_left, "What it is")
    y_left = _draw_para(
        c,
        left,
        y_left,
        "A multi-tenant gym management web app with a gym admin portal and a platform admin back office. "
        "Includes an optional customer-support chatbot backed by Gemini and a local markdown knowledge base.",
    )
    y_left -= 6

    y_left = _draw_heading(c, left, y_left, "Who it's for")
    y_left = _draw_bullets(
        c,
        left,
        y_left,
        [
            "Primary: gym owner/manager (tenant admin) managing members, attendance, packages, and payments.",
            "Also: platform operator (super admin) onboarding and administering gyms/tenants.",
        ],
    )
    y_left -= 4

    y_left = _draw_heading(c, left, y_left, "What it does (key features)")
    y_left = _draw_bullets(
        c,
        left,
        y_left,
        [
            "Member management (create/edit/list member profiles under a tenant).",
            "Gym packages (CRUD packages; assign packages to members via recorded payments).",
            "Membership/payment tracking (start/end dates; statuses like active/expired/frozen).",
            "Attendance tracking (manual check-in/out + date-range attendance report).",
            "Platform admin for tenants (create/approve/reject/suspend/reactivate; transfer ownership; reset password).",
            "Subscriptions & billing (plans, subscriptions, manual payment records, invoice view).",
            "Support chatbot endpoint (`POST /chatbot`) using Gemini + cached `knowledge-base/*.md` context.",
        ],
    )
    y_left -= 6

    y_left = _draw_heading(c, left, y_left, "Data model (at a glance)")
    y_left = _draw_bullets(
        c,
        left,
        y_left,
        [
            "`Tenant` owns users, gym packages, member packages, subscriptions, and platform payments.",
            "`User` has a `Role` (member/staff/admin) and may have `MemberPackage` memberships.",
            "`Attendance` records check-in/out timestamps per member.",
        ],
    )

    # Right column
    y_right = _draw_heading(c, right, y_right, "How it works (repo-evidenced architecture)")
    y_right = _draw_bullets(
        c,
        right,
        y_right,
        [
            "Browser -> Laravel routes (`routes/web.php`) -> Controllers -> Blade views (`resources/views/*`).",
            "Data layer: Eloquent models with `tenant_id` and a `TenantScoped` global scope set by `IdentifyTenant` middleware.",
            "Dev DB: SQLite (`database/database.sqlite`); sessions/queue/cache configured to use the database in `.env.example`.",
            "Chatbot flow: `POST /chatbot` -> `ChatbotController` loads markdown knowledge base (cached) -> calls Gemini HTTP API -> returns JSON reply.",
        ],
    )
    y_right -= 2

    y_right = _draw_heading(c, right, y_right, "Not found in repo")
    y_right = _draw_bullets(
        c,
        right,
        y_right,
        [
            "Working WhatsApp send implementation (several controllers contain TODO placeholders).",
            "eSewa/Khalti payment gateway API integration (UI/DB enum values exist, but no gateway HTTP calls found).",
        ],
        font_size=10,
        leading=12,
    )
    y_right -= 2

    y_right = _draw_heading(c, right, y_right, "How to run (minimal)")
    y_right = _draw_bullets(
        c,
        right,
        y_right,
        [
            "From repo root: `composer run setup` (installs deps, copies `.env`, generates key, migrates, builds assets).",
            "Start dev: `composer run dev` (server + queue worker + logs + Vite).",
            "Optional: set `GEMINI_API_KEY` in `.env` to enable the chatbot.",
            "Optional: `composer run test` and `./vendor/bin/pint`.",
        ],
    )

    # Footer
    c.setFont("Helvetica", 8)
    c.setFillGray(0.35)
    c.drawRightString(page_w - margin, margin - 8, "Generated from repo evidence (no external assumptions).")

    c.showPage()
    c.save()


if __name__ == "__main__":
    repo_root = Path(__file__).resolve().parents[2]
    build_pdf(repo_root / "output" / "pdf" / "GymSathi-OnePager.pdf")
